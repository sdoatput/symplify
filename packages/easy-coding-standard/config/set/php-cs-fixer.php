<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\MultilineCommentOpeningClosingFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoTrailingCommaInListCallFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededCurlyBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAnnotationWithoutDotFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarAnnotationCorrectOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SemicolonAfterInstructionFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\StringNotation\EscapeImplicitBackslashesFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypehintFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    $ecsConfig->ruleWithConfiguration(BracesFixer::class, [
        'allow_single_line_closure' => true,
    ]);

    $ecsConfig->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'method' => 'one',
        ],
    ]);

    $ecsConfig->ruleWithConfiguration(ClassDefinitionFixer::class, [
        'single_line' => true,
    ]);

    $ecsConfig->rule(CombineConsecutiveIssetsFixer::class);
    $ecsConfig->rule(CombineConsecutiveUnsetsFixer::class);
    $ecsConfig->rule(CompactNullableTypehintFixer::class);
    $ecsConfig->rule(ConcatSpaceFixer::class);
    $ecsConfig->rule(ConstantCaseFixer::class);
    $ecsConfig->rule(DeclareEqualNormalizeFixer::class);
    $ecsConfig->rule(ElseifFixer::class);
    $ecsConfig->rule(EncodingFixer::class);
    $ecsConfig->rule(EscapeImplicitBackslashesFixer::class);
    $ecsConfig->rule(ExplicitIndirectVariableFixer::class);
    $ecsConfig->rule(ExplicitStringVariableFixer::class);
    $ecsConfig->rule(FullOpeningTagFixer::class);
    $ecsConfig->rule(FullyQualifiedStrictTypesFixer::class);
    $ecsConfig->rule(FunctionDeclarationFixer::class);
    $ecsConfig->rule(FunctionTypehintSpaceFixer::class);
    $ecsConfig->rule(HeredocToNowdocFixer::class);
    $ecsConfig->rule(IncludeFixer::class);
    $ecsConfig->rule(IncrementStyleFixer::class);
    $ecsConfig->rule(IndentationTypeFixer::class);
    $ecsConfig->rule(LineEndingFixer::class);
    $ecsConfig->rule(LowercaseCastFixer::class);
    $ecsConfig->rule(LowercaseKeywordsFixer::class);
    $ecsConfig->rule(LowercaseStaticReferenceFixer::class);
    $ecsConfig->rule(MagicConstantCasingFixer::class);
    $ecsConfig->rule(MagicMethodCasingFixer::class);

    $ecsConfig->ruleWithConfiguration(MethodArgumentSpaceFixer::class, [
        'on_multiline' => 'ensure_fully_multiline',
    ]);

    $ecsConfig->rule(MethodChainingIndentationFixer::class);
    $ecsConfig->rule(MultilineCommentOpeningClosingFixer::class);

    $ecsConfig->ruleWithConfiguration(MultilineWhitespaceBeforeSemicolonsFixer::class, [
        'strategy' => 'new_line_for_chained_calls',
    ]);

    $ecsConfig->rule(NativeFunctionCasingFixer::class);
    $ecsConfig->rule(NativeFunctionTypeDeclarationCasingFixer::class);
    $ecsConfig->rule(NewWithBracesFixer::class);
    $ecsConfig->rule(NoAlternativeSyntaxFixer::class);
    $ecsConfig->rule(NoBinaryStringFixer::class);
    $ecsConfig->rule(NoBlankLinesAfterClassOpeningFixer::class);
    $ecsConfig->rule(NoBlankLinesAfterPhpdocFixer::class);
    $ecsConfig->rule(NoBreakCommentFixer::class);
    $ecsConfig->rule(NoClosingTagFixer::class);
    $ecsConfig->rule(NoEmptyCommentFixer::class);
    $ecsConfig->rule(NoEmptyPhpdocFixer::class);
    $ecsConfig->rule(NoEmptyStatementFixer::class);

    $ecsConfig->ruleWithConfiguration(NoExtraBlankLinesFixer::class, [
        'tokens' => [
            'break',
            'continue',
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'throw',
            'use',
        ],
    ]);

    $ecsConfig->rule(NoLeadingImportSlashFixer::class);
    $ecsConfig->rule(NoLeadingNamespaceWhitespaceFixer::class);
    $ecsConfig->rule(NoMixedEchoPrintFixer::class);
    $ecsConfig->rule(NoMultilineWhitespaceAroundDoubleArrowFixer::class);
    $ecsConfig->rule(NoNullPropertyInitializationFixer::class);
    $ecsConfig->rule(NoShortBoolCastFixer::class);
    $ecsConfig->rule(NoSinglelineWhitespaceBeforeSemicolonsFixer::class);
    $ecsConfig->rule(NoSpacesAfterFunctionNameFixer::class);
    $ecsConfig->rule(NoSpacesAroundOffsetFixer::class);
    $ecsConfig->rule(NoSpacesInsideParenthesisFixer::class);
    $ecsConfig->rule(NoSuperfluousElseifFixer::class);

    $ecsConfig->ruleWithConfiguration(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_mixed' => true,
        'allow_unused_params' => true,
    ]);

    $ecsConfig->rule(NoTrailingCommaInListCallFixer::class);
    $ecsConfig->rule(NoTrailingCommaInSinglelineArrayFixer::class);
    $ecsConfig->rule(NoTrailingWhitespaceFixer::class);
    $ecsConfig->rule(NoTrailingWhitespaceInCommentFixer::class);
    $ecsConfig->rule(NoUnneededControlParenthesesFixer::class);

    $ecsConfig->ruleWithConfiguration(NoUnneededCurlyBracesFixer::class, [
        'namespaces' => true,
    ]);

    $ecsConfig->rule(NoUnsetCastFixer::class);
    $ecsConfig->rule(NoUnusedImportsFixer::class);
    $ecsConfig->rule(NoUselessElseFixer::class);
    $ecsConfig->rule(NoUselessReturnFixer::class);
    $ecsConfig->rule(NoWhitespaceBeforeCommaInArrayFixer::class);
    $ecsConfig->rule(NoWhitespaceInBlankLineFixer::class);
    $ecsConfig->rule(NormalizeIndexBraceFixer::class);
    $ecsConfig->rule(ObjectOperatorWithoutWhitespaceFixer::class);
    $ecsConfig->rule(OrderedClassElementsFixer::class);
    $ecsConfig->rule(OrderedImportsFixer::class);
    $ecsConfig->rule(PhpUnitFqcnAnnotationFixer::class);
    $ecsConfig->rule(PhpUnitInternalClassFixer::class);
    $ecsConfig->rule(PhpUnitMethodCasingFixer::class);
    $ecsConfig->rule(PhpUnitTestClassRequiresCoversFixer::class);
    $ecsConfig->rule(PhpdocAddMissingParamAnnotationFixer::class);

    $ecsConfig->ruleWithConfiguration(PhpdocAlignFixer::class, [
        'tags' => ['method', 'param', 'property', 'return', 'throws', 'type', 'var'],
    ]);

    $ecsConfig->rule(PhpdocAnnotationWithoutDotFixer::class);
    $ecsConfig->rule(PhpdocIndentFixer::class);
    $ecsConfig->rule(PhpdocNoAccessFixer::class);
    $ecsConfig->rule(PhpdocNoAliasTagFixer::class);
    $ecsConfig->rule(PhpdocNoEmptyReturnFixer::class);
    $ecsConfig->rule(PhpdocNoPackageFixer::class);
    $ecsConfig->rule(PhpdocNoUselessInheritdocFixer::class);
    $ecsConfig->rule(PhpdocOrderFixer::class);
    $ecsConfig->rule(PhpdocReturnSelfReferenceFixer::class);
    $ecsConfig->rule(PhpdocScalarFixer::class);
    $ecsConfig->rule(PhpdocSeparationFixer::class);
    $ecsConfig->rule(PhpdocSingleLineVarSpacingFixer::class);
    $ecsConfig->rule(PhpdocSummaryFixer::class);
    $ecsConfig->rule(PhpdocToCommentFixer::class);
    $ecsConfig->rule(PhpdocTrimFixer::class);
    $ecsConfig->rule(PhpdocTrimConsecutiveBlankLineSeparationFixer::class);
    $ecsConfig->rule(PhpdocTypesFixer::class);
    $ecsConfig->rule(PhpdocTypesOrderFixer::class);
    $ecsConfig->rule(PhpdocVarAnnotationCorrectOrderFixer::class);
    $ecsConfig->rule(PhpdocVarWithoutNameFixer::class);
    $ecsConfig->rule(ProtectedToPrivateFixer::class);
    $ecsConfig->rule(ReturnAssignmentFixer::class);
    $ecsConfig->rule(ReturnTypeDeclarationFixer::class);
    $ecsConfig->rule(SemicolonAfterInstructionFixer::class);
    $ecsConfig->rule(ShortScalarCastFixer::class);
    $ecsConfig->rule(SimpleToComplexStringVariableFixer::class);
    $ecsConfig->rule(SingleBlankLineAtEofFixer::class);
    $ecsConfig->rule(SingleBlankLineBeforeNamespaceFixer::class);
    $ecsConfig->rule(SingleClassElementPerStatementFixer::class);
    $ecsConfig->rule(SingleImportPerStatementFixer::class);
    $ecsConfig->rule(SingleLineAfterImportsFixer::class);
    $ecsConfig->rule(SingleLineCommentStyleFixer::class);
    $ecsConfig->rule(SingleQuoteFixer::class);
    $ecsConfig->rule(SingleTraitInsertPerStatementFixer::class);

    $ecsConfig->ruleWithConfiguration(SpaceAfterSemicolonFixer::class, [
        'remove_in_empty_for_expressions' => true,
    ]);

    $ecsConfig->rule(StandardizeIncrementFixer::class);
    $ecsConfig->rule(StandardizeNotEqualsFixer::class);
    $ecsConfig->rule(SwitchCaseSemicolonToColonFixer::class);
    $ecsConfig->rule(SwitchCaseSpaceFixer::class);
    $ecsConfig->rule(TernaryOperatorSpacesFixer::class);

    $ecsConfig->ruleWithConfiguration(TrailingCommaInMultilineFixer::class, [
        'elements' => [TrailingCommaInMultilineFixer::ELEMENTS_ARRAYS],
    ]);

    $ecsConfig->rules([
        TrimArraySpacesFixer::class,
        UnaryOperatorSpacesFixer::class,
        VisibilityRequiredFixer::class,
        WhitespaceAfterCommaInArrayFixer::class,
        YodaStyleFixer::class,
        BinaryOperatorSpacesFixer::class,
        BlankLineAfterNamespaceFixer::class,
        BlankLineAfterOpeningTagFixer::class,
        BlankLineBeforeStatementFixer::class,
        CastSpacesFixer::class,
        AlignMultilineCommentFixer::class,
        ArrayIndentationFixer::class,
    ]);
};
