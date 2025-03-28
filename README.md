# Unicode tools

> [!CAUTION]
> This package is under development. Expected breaking changes to occur any time.
> 
> The code generated by this package is not checked in any way or form.
> 
> USE AT YOUR OWN DISCRETION.

## Description

This package contains tools for generating unicode based[^1] lookup tables.

## Preparation

> [!NOTE]
> Composer should have downloaded the required files for you.

Use either of the following commands to acquire the latest unicode data:

```BASH
composer run-script get-ucd
```

## Use cases
- [Reverse `toUppercase` lookup](#reverse-touppercase-lookup)
- [Reverse case folding](#reverse-case-folding)
  - [Reverse simple case folding](#reverse-simple-case-folding)
  - [Reverse full case folding](#reverse-full-case-folding) - TBD

## Reverse `toUppercase` lookup

This tool generates a code snippet that contains the reverse mapping from one code point (`$codePoint`) to all its lowercase pendants. Code points that do not have more than one mapping are passed to `mb_case_fold($codePoint, MB_CASE_LOWER, 'UTF-8')`.

> [!NOTE]
> That the resulting list always contains the input code point as well.

#### Usage

```BASH
php bin/reverse-to-uppercase.php <output_path>
```

## Reverse case folding

These tools each generate a code snippet that contains the reverse mapping from one code point (`$codePoint`) to all its case folded pendants. Code points that do not have more than one mapping are passed to `mb_case_fold($codePoint, MB_CASE_FOLD_SIMPLE, 'UTF-8')`.

> [!NOTE]
> That the resulting list always contains the input code point as well.

As unicode defines two methods of case folding
> The data supports both implementations that require simple case foldings
> (where string lengths don't change), and implementations that allow full case folding
> (where string lengths may grow). Note that where they can be supported, the
> full case foldings are superior: for example, they allow "MASSE" and "Maße" to match.
the following uses cases are defined.

### Reverse simple case folding

#### Usage

```BASH
php bin/reverse-simple-case-folding.php <output_path>
```

### Reverse full case folding

> [!IMPORTANT]
> Full case folding reversal is not implemented, yet.

## Testing

Run the following commands to test this project on your machine:
```BASH
phpunit
infection
phpstan
```

Make sure that you have `xdebug` installed and set to coverage mode before running `infection`.

[^1]: The unicode files are located [here](https://unicode.org/Public/UCD/latest/ucd/).