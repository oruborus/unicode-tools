<?php

declare(strict_types=1);

namespace Oru\UnicodeTools\UseCases;

use Oru\UnicodeTools\CaseFolding\Entry;
use Oru\UnicodeTools\CaseFolding\Status;
use Oru\UnicodeTools\Support\Output;

use function array_filter;
use function count;
use function implode;
use function ksort;
use function sprintf;

final readonly class ReverseSimpleCaseFolding
{
    /** @param iterable<int, Entry> $input */
    public function __construct(
        private iterable $input,
        private Output $output,
    ) {}

    public function create(): void
    {
        $mappings = $this->collectMappings();
        $mappings = $this->compactMappings($mappings);

        $this->output->putContents($this->render($mappings));
    }

    /** @return array<string, list<string>> */
    private function collectMappings(): array
    {
        $mappings = [];
        foreach ($this->input as $entry) {
            if ($entry->status === Status::COMMON || $entry->status === Status::SIMPLE) {
                $mappings['0x' . $entry->mapping][] = '0x' . $entry->code;
            }
        }

        ksort($mappings);

        return $mappings;
    }

    /** 
     * @param array<string, list<string>> $mappings
     * @return array<string, list<string>>
     */
    private function compactMappings(array $mappings): array
    {
        $mappings = array_filter($mappings, fn(array $mapping): bool => count($mapping) > 1);
        $mappings['default'] = ['\mb_ord(\mb_convert_case(\mb_chr($codePoint, \'UTF-8\'), \MB_CASE_FOLD_SIMPLE, \'UTF-8\'), \'UTF-8\')'];

        return $mappings;
    }

    /** @param array<string, list<string>> $mappings */
    private function render(array $mappings): string
    {
        return <<<PHP
        <?php
        
        match (\$codePoint) {
        {$this->renderMatchArms($mappings)}
        };

        PHP;
    }

    /** @param array<string, list<string>> $mappings */
    private function renderMatchArms(array $mappings): string
    {
        $matchArms = array_map($this->renderMatchArm(...), array_keys($mappings), $mappings);

        return implode("\n", $matchArms);
    }

    /** @param list<string> $mapping */
    private function renderMatchArm(string $condition, array $mapping): string
    {
        return sprintf("    %s => [\$codePoint, %s],", $condition, implode(', ', $mapping));
    }
}
