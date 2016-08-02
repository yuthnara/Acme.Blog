<?php
namespace Acme\Blog\Validation\Validator;

/*
 * This file is part of the TYPO3.Flow package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Validation\Validator\AbstractValidator;
use TYPO3\Flow\Validation\Exception\InvalidValidationOptionsException;
use TYPO3\Flow\Utility\TypeHandling;
use TYPO3\Flow\Reflection\ClassSchema;
use TYPO3\Flow\Reflection\ObjectAccess;
use TYPO3\Flow\Reflection\ReflectionService;

/**
 * Validator for exist of entities.
 *
 * @api
 */
class EqualsValidator extends AbstractValidator {

    /**
     * @Flow\Inject
     * @var ReflectionService
     */
    protected $reflectionService;

    /**
     * @var array
     */
    protected $supportedOptions = array(
        'propertyOne' => array(NULL, 'name of the first property', 'string', TRUE),
        'propertyTwo' => array(NULL, 'name of the second property', 'string', TRUE)
    );

    /**
     * @param mixed $value The value that should be validated
     * @return void
     * @throws InvalidValidationOptionsException
     */
    protected function isValid($value) {
        if (!is_object($value)) {
            throw new InvalidValidationOptionsException('The value supplied for the EqualsValidator must be an object.', 1470132615);
        }

        /** @var ClassSchema $classSchema */
        $classSchema = $this->reflectionService->getClassSchema(TypeHandling::getTypeForValue($value));
        if ($classSchema === null || $classSchema->getModelType() !== ClassSchema::MODELTYPE_ENTITY) {
            throw new InvalidValidationOptionsException('The object supplied for the EqualsValidator must be an entity.', 1470132607);
        }

        $propertyOneName = $this->options['propertyOne'];
        $propertyTwoName = $this->options['propertyTwo'];
        $identityProperties = array($propertyOneName, $propertyTwoName);
        foreach ($identityProperties as $propertyName) {
            if ($classSchema->hasProperty($propertyName) === false) {
                throw new InvalidValidationOptionsException(sprintf('The custom identity property name "%s" supplied for the EqualsValidator does not exists in "%s".', $propertyName, $classSchema->getClassName()), 1470132595);
            }
        }

        if (! is_string($propertyOneName) || ! is_string($propertyTwoName)) {
            throw new InvalidValidationOptionsException('The option "property" must be a string.', 1470131314);
        }

        $propertyOne = ObjectAccess::getProperty($value, $propertyOneName);
        $propertyTwo = ObjectAccess::getProperty($value, $propertyTwoName);
        if (trim($propertyOne) === trim($propertyTwo)) {
            $this->addError('The property "%s" and "%s" should not be the same.', 1470132521, array($propertyOneName, $propertyTwoName));
        }
    }
}
