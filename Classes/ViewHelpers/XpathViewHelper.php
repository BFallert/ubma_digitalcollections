<?php
namespace Ubma\UbmaDigitalcollections\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Alexander Bigga <alexander.bigga@slub-dresden.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to get page info
 *
 * # Example: Basic example
 * <code>
 * <si:pageInfo page="123">
 *	<span>123</span>
 * </code>
 * <output>
 * Will output the page record
 * </output>
 *
 * @package TYPO3
 */
class XpathViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('xpath', 'string', 'Xpath Expression', true);
        $this->registerArgument('htmlspecialchars', 'boolean', 'Use htmlspecialchars() on the found result.', false, true);
        $this->registerArgument('returnArray', 'boolean', 'Return results in an array instead of string.', false, false);
    }

    /**
     * Render the supplied DateTime object as a formatted date.
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     */
    public static function renderStatic(
      array $arguments,
      \Closure $renderChildrenClosure,
      RenderingContextInterface $renderingContext
    ) {
        $xpath = $arguments['xpath'];
        $htmlspecialchars = $arguments['htmlspecialchars'];
        $returnArray = $arguments['returnArray'];

        $doc = GeneralUtility::makeInstance(\Ubma\UbmaDigitalcollections\Helpers\GetDoc::class);

        $result = $doc->getXpath($xpath);

        if (is_array($result)) {
          foreach ($result as $row) {
            if ($returnArray) {
              $output[] = $htmlspecialchars ? htmlspecialchars(trim($row)) : trim($row);
            } else {
              $output .= $htmlspecialchars ? htmlspecialchars(trim($row)) : trim($row) . ' ';
            }
          }
        } else {
          if ($returnArray) {
            $output[] = $htmlspecialchars ? htmlspecialchars(trim($row)) : trim($row);
          } else {
            $output = $htmlspecialchars ? htmlspecialchars(trim($row)) : trim($row);
          }
        }

        if (! $returnArray) {
            return trim($output);
        } else {
            return $output;
        }
    }
}
