<?php
declare(strict_types = 1);

use Symfony\Component\Finder\Finder;

$finder = Finder::create()
    ->name('/\\.php$/')
    ->notName('ext_localconf.php')
    ->notName('ext_tables.php')
    ->in(__DIR__ . '/packages');

return PhpCsFixer\Config::create()
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation'     => true,
        '@PSR2'                   => true,
        'align_multiline_comment' => [
            'comment_type' => 'phpdocs_like',
        ],
        'array_syntax'           => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default'   => 'single_space',
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ],
        ],
        'blank_line_before_statement' => [
            'statements' => ['if', 'try', 'return'],
        ],
        'cast_spaces'                          => ['space' => 'none'],
        'concat_space'                         => ['spacing' => 'one'],
        'declare_equal_normalize'              => ['space' => 'single'],
        'declare_strict_types'                 => true,
        'doctrine_annotation_array_assignment' => [
            'operator' => '=',
        ],
        'dir_constant'                => true,
        'ereg_to_preg'                => true,
        'escape_implicit_backslashes' => [
            'double_quoted'  => true,
            'heredoc_syntax' => true,
            'single_quoted'  => true,
        ],
        'explicit_indirect_variable'       => true,
        'explicit_string_variable'         => true,
        'function_typehint_space'          => true,
        'hash_to_slash_comment'            => true,
        'linebreak_after_opening_tag'      => true,
        'lowercase_cast'                   => true,
        'magic_constant_casing'            => true,
        'modernize_types_casting'          => true,
        'native_function_casing'           => true,
        'new_with_braces'                  => true,
        'no_alias_functions'               => true,
        'no_blank_lines_after_phpdoc'      => true,
        'no_blank_lines_before_namespace'  => true,
        'no_empty_comment'                 => true,
        'no_empty_phpdoc'                  => true,
        'no_empty_statement'               => true,
        'no_extra_consecutive_blank_lines' => true,
        'no_leading_import_slash'          => true,
        'no_leading_namespace_whitespace'  => true,
        'no_mixed_echo_print'              => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_null_property_initialization'             => true,
        'no_php4_constructor'                         => true,
        'no_short_bool_cast'                          => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_superfluous_elseif'                       => true,
        'no_spaces_after_function_name'               => true,
        'no_spaces_around_offset'                     => [
            'positions' => ['inside', 'outside'],
        ],
        'no_spaces_inside_parenthesis'          => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unneeded_control_parentheses'       => true,
        'no_unused_imports'                     => true,
        'no_useless_else'                       => true,
        'no_useless_return'                     => true,
        'no_whitespace_in_blank_line'           => true,
        'non_printable_character'               => false,
        'ordered_class_elements'                => true,
        'ordered_imports'                       => true,
        'phpdoc_indent'                         => true,
        'phpdoc_scalar'                         => true,
        'short_scalar_cast'                     => true,
        'single_line_comment_style'             => true,
        'phpdoc_no_access'                      => true,
        'phpdoc_no_empty_return'                => true,
        'phpdoc_no_package'                     => true,
        'phpdoc_trim'                           => true,
        'phpdoc_types'                          => true,
        'phpdoc_types_order'                    => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'return_type_declaration'               => ['space_before' => 'none'],
        'single_quote'                          => [
            'strings_containing_single_quote_chars' => true,
        ],
        'standardize_not_equals'          => true,
        'visibility_required'             => true,
        'ternary_operator_spaces'         => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder);
