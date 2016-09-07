<?php
namespace Sup7even\Theme\ViewHelpers;

use \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use function GuzzleHttp\json_encode;

/**
 * parses a given scss file and extracts the breakpoint variables
 */
class ScssBreakpointViewHelper extends AbstractViewHelper {

	public function initializeArguments() {
		$this->registerArgument('file', 'string', 'Variables SCSS File', FALSE, FALSE);
	}

	/**
	 * @return array
	 */
	public function render() {
		$arr = array();

		if (!isset($this->arguments['file']) || $this->arguments['file'] == '') {
			$file = 'EXT:theme/Resources/Private/Scss/globals/variables.scss';
		}
			else {
				$file = $this->arguments['file'];
			}
            
		if (stripos($file, 'EXT:') !== false) {
		    $ext = array_shift(explode('/', $this->arguments['file']));
		    $extPath = ExtensionManagementUtility::extPath(str_replace('EXT:', '', $ext));
		    $file = str_replace($ext .'/', $extPath, $this->arguments['file']);
		}

		if (file_exists($file)) {
			$file = file_get_contents($file);
			preg_match_all('/\$grid\-breakpoints\: \(([a-z:0-9,\.\s]+)\)/', $file, $preg);
			$arr = array();
			if (isset($preg[1][0])) {
				$string = trim($preg[1][0]);
				$queries = explode(',', $string);

				foreach($queries as $key => $query) {
					if ($query != '') {
						$tmp = explode(':', $query);
						$arr[trim($tmp[0])] = trim($tmp[1]);

						$unit = (trim(substr($tmp[1], -2)) == '0') ? '' : trim(substr($tmp[1], -2));

						if (isset($queries[$key + 1]) && $queries[$key + 1] != '') {
							$tmp2 = explode(':', $queries[$key + 1]);
							switch ($unit) {
								case 'px':
									$arr[trim($tmp[0]) ."-max"] = trim((int)$tmp2[1]) - 1 . $unit;
								break;

								default:
									$arr[trim($tmp[0]) ."-max"] = trim((int)$tmp2[1]) - 0.1 . $unit;
								break;
							}
						}
					}
				}
			}
		}

		return json_encode($arr);
	}

}
