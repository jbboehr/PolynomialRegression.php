<?php
/**
 * @package PolynomialRegression
 * @author Andrew Que ({@link http://www.DrQue.net/})
 * @link http://PolynomialRegression.drque.net/ Project home page.
 * @copyright Copyright (c) 2009, 2012-2015, Andrew Que
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.2.1
 */

namespace DrQue;

/**
 * Interface for weighting the regression.  Implementations of this interface can be used to
 * apply a custom weighting value that emphasizes some values more than others.
 *
 * Note: BC math in the weighting interface is optional as long as the number are not expected
 * to become too small or large.
 *
 * @since Version 1.2.1
 */
interface WeightingInterface
{
    /**
     * Return the weighting term for the given index.
     * Note that the index begins with 1, and counts up for each data point added.  Thus when
     * data is weighted, the order it is entered is important.
     *
     * @param int $index Current index for which to return weighting term.
     */
    public function getWeight( $index );
}
