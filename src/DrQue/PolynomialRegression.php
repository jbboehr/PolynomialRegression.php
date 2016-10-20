<?php
/*=========================================================================*/
/* Name: PolynomialRegression.php                                          */
/* Uses: Calculates and returns coefficients for polynomial regression.    */
/* Date: 06/01/2009                                                        */
/* Author: Andrew Que (http://www.DrQue.net/)                              */
/* Revisions:                                                              */
/*  0.8 - 06/01/2009- QUE - Creation.                                      */
/*  0.9 - 06/14/2012- QUE -                                                */
/*   + Bug fix: removed notice causes by uninitialized variable.           */
/*   + Converted naming convention.                                        */
/*   + Fix spelling errors (or the ones I found).                          */
/*   + Changed to row-echelon method for solving matrix which is much      */
/*     faster than the determinant method.                                 */
/*  0.91 - 05/17/2013- QUE -                                               */
/*   = Changed name to Polynonial regression as this is more fitting to    */
/*     to the function.                                                    */
/*  0.92 - 12/28/2013- QUE -                                               */
/*   + Added forced offset.                                                */
/*  1.00 - 12/29/2013 - QUE -                                              */
/*   + Forced offset changed to allow any term to be forced.               */
/*    Unit complete.  Correlation coefficient (r-squared) has been         */
/*    implemented externally in the demos.                                 */
/*  1.1 - 2015/05/05 - QUE -                                               */
/*   + 'interpolate' is now static as it does not need an instance to      */
/*     operate.  Useful if coefficients have been calculated elsewhere.    */
/*   - Deprecated 'setDegree' function.  This is the wrong terminology for */
/*     what the function does.  It actually sets the number of             */
/*     coefficients for the polynomial.  The degree of the polynomial is   */
/*     the number of coefficients less one.  Made the identical function   */
/*     'setNumberOfCoefficient' to replace it.                             */
/*   + Added getter functions for anything that has a set function.        */
/*  1.2 - 2015/02/09 - QUE -                                               */
/*   + Support for weighting.                                              */
/*   + Slight improvement in data accumulation.                            */
/*  1.2.1 - 2015/02/17 - QUE -                                             */
/*   + Bug fix to LinearWeighting class.                                   */
/*                                                                         */
/* This project is maintained at:                                          */
/*    http://PolynomialRegression.drque.net/                               */
/*                                                                         */
/* ----------------------------------------------------------------------- */
/*                                                                         */
/* Polynomial regression class.                                            */
/* Copyright (C) 2009, 2012-2015 Andrew Que                                */
/*                                                                         */
/* This program is free software: you can redistribute it and/or modify    */
/* it under the terms of the GNU General Public License as published by    */
/* the Free Software Foundation, either version 3 of the License, or       */
/* (at your option) any later version.                                     */
/*                                                                         */
/* This program is distributed in the hope that it will be useful,         */
/* but WITHOUT ANY WARRANTY; without even the implied warranty of          */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           */
/* GNU General Public License for more details.                            */
/*                                                                         */
/* You should have received a copy of the GNU General Public License       */
/* along with this program.  If not, see <http://www.gnu.org/licenses/>.   */
/*                                                                         */
/* ----------------------------------------------------------------------- */
/*                                                                         */
/*                      (C) Copyright 2009, 2012-2015                      */
/*                               Andrew Que                                */
/*=========================================================================*/
/**
 * Polynomial regression.
 *
 * <p>
 * Used for calculating polynomial regression coefficients.  Useful for
 * linear and non-linear regression, and polynomial curve fitting.
 *
 * @package PolynomialRegression
 * @author Andrew Que ({@link http://www.DrQue.net/})
 * @link http://PolynomialRegression.drque.net/ Project home page.
 * @copyright Copyright (c) 2009, 2012-2015, Andrew Que
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.2.1
 */

namespace DrQue;

/**
 * Used for calculating polynomial regression coefficients and interpolation using
 * those coefficients.  Useful for linear and non-linear regression, and polynomial
 * curve fitting.
 *
 * Note: Requires BC math to be compiled into PHP.  Higher-degree polynomials end up
 * with very large/small numbers, requiring an arbitrary precision arithmetic.  Make sure
 * to set "bcscale" as coefficients will likely have decimal values.
 *
 * Quick example of using this unit to calculate linear regression (1st degree polynomial):
 *
 * <pre>
 * $regression = new PolynomialRegression( 2 );
 * // ...
 * $regression->addData( $x, $y );
 * // ...
 * $coefficients = $regression->getCoefficients();
 * // ...
 * $y = $regression->interpolate( $coefficients, $x );
 * </pre>
 *
 */
class PolynomialRegression
{
    /**
     * @var array Array of running sum of x^n.
     */
    private $xPowers;

    /**
     * @var array Array of running sum of x*y powers.
     */
    private $xyPowers;

    /**
     * @var integer Number of coefficients.
     */
    private $numberOfCoefficient;

    /**
     * @var array Array of forcing terms.
     */
    private $forcedValue;

    /**
     * @var integer The index of the current element.  Basiclly a count of data added.
     */
    private $index = 0;

    /**
     * @var WeightingInterface The weighting interface or NULL is unused
     */
    private $weightingInterface;

    /**
     * Constructor
     *
     * Create new class.
     * @param integer $numberOfCoefficient Number of coefficients in polynomial (degree
     *   of polynomial + 1).
     */
    public function __construct( $numberOfCoefficient = 3 )
    {
        $this->numberOfCoefficient = $numberOfCoefficient;
        $this->reset();

    } // __construct

    /**
     * Reset data.
     *
     * Clear all internal data and prepare for new calculation.
     * Must be called *after* setNumberOfCoefficient if number of coefficients has
     * changed.
     */
    public function reset()
    {
        $this->forcedValue = array();
        $this->xPowers = array();
        $this->xyPowers = array();
        $this->index = 0;
        $this->weightingInterface = NULL;

        $squares = ( $this->numberOfCoefficient - 1 ) * 2;

        // Initialize power arrays.
        for ( $index = 0; $index <= $squares; ++$index )
        {
            $this->xPowers[ $index ] = 0;
            $this->xyPowers[ $index ] = 0;
        }

    } // reset

    /**
     * Set degree (Deprecated).
     *
     * This is the maximum number of coefficients the polynomial function that
     * will be calculate.  Note that the request for coefficients can be lower
     * then this value.  If number is higher, data must be reset and
     * added again.
     * @param int $numberOfCoefficient Number of coefficients.
     * @deprecated Deprecated in version 1.1 because the name doesn't reflect what
     *   the function actually does.  Use 'setNumberOfCoefficient' instead--operations
     *   are identical.
     */
    public function setDegree( $numberOfCoefficient )
    {
        $this->numberOfCoefficient = $numberOfCoefficient;

    } // setDegree

    /**
     * Set the number of coefficients to calculate.
     *
     * This is the maximum number of coefficients the polynomial function that
     * will be calculate.  Note that the request for coefficients can be lower
     * then this value.  If number is higher, data must be reset and
     * added again.
     * @param int $numberOfCoefficient Number of coefficients.
     * @since Version 1.1
     */
    public function setNumberOfCoefficient( $numberOfCoefficient )
    {
        $this->numberOfCoefficient = $numberOfCoefficient;

    } // setNumberOfCoefficient

    /**
     * Get the number of coefficients to calculate.
     *
     * Returns the number of coefficients calculated.
     * @return int Number of coefficients.
     * @since Version 1.1
     */
    public function getNumberOfCoefficient()
    {
        return $this->numberOfCoefficient;

    } // getnumberOfCoefficient

    /**
     * Set a forced coefficient.
     *
     * Force a coefficient to be assumed a specific value for the calculation.
     * Most often used to force an offset of zero, but can be used to set any
     * known coefficient for a set of data.
     * @param int $coefficient Which coefficient to force.
     * @param float $value Value to force this coefficient.
     * @since Version 1.0
     */
    public function setForcedCoefficient( $coefficient, $value )
    {
        $this->forcedValue[ $coefficient ] = $value;

    } // setForcedCoefficient

    /**
     * Get a forced coefficient.
     *
     * Get a previously set forced coefficient.
     * @param int $coefficient Which coefficient.
     * @return float Value of this force this coefficient.  Null if the
     *   coefficient isn't being forced.
     * @since Version 1.1
     */
    public function getForcedCoefficient( $coefficient )
    {
        $result = null;
        if ( isset( $this->forcedValue[ $coefficient ] ) )
            $result = $this->forcedValue[ $coefficient ];

        return $result;

    } // getForcedCoefficient

    /**
     * Set a weighting interface.
     *
     * The regression can be weighted on a per-index basis using a weighting
     * interface.  An instance of this interface can be set here.
     * @param WeightingInterface $weightingInterface Instance of weighting system
     *   to be used.
     * @since Version 1.2
     */
    public function setWeighting( WeightingInterface $weightingInterface )
    {
        $this->weightingInterface = $weightingInterface;
    }

    /**
     * Get the weighting interface.
     *
     * Return the current weighting interface being used.  Returns NULL if no
     * interface is used.
     * @return WeightingInterface
     * @since Version 1.2
     */
    public function getWeighting()
    {
        return $this->weightingInterface;
    }

    /**
     * Add data.
     *
     * Add a data point to calculation.
     * @param float $x Some real value.
     * @param float $y Some real value corresponding to $x.
     */
    public function addData( $x, $y )
    {
        $squares = ( $this->numberOfCoefficient - 1 ) * 2;

        // Get weighting term for this index.
        $this->index += 1;
        $weight = NULL;
        if ( NULL !== $this->weightingInterface ) {
            $weight = $this->weightingInterface->getWeight($this->index);
        }

        // Remove the effect of the forced coefficient from this value.
        foreach ( $this->forcedValue as $coefficient => $value )
        {
            $sub = bcpow( $x, $coefficient );
            $sub = bcmul( $sub, $value );
            $y = bcsub( $y, $sub );
        }

        // Accumulation of $x raised to the power of the loop iteration.
        // $xSum = pow( $x, $index ) starting with pow( $x, 0 ) which is 1.
        $xSum = 1;

        // Accumulate new data to power sums.
        for ( $index = 0; $index <= $squares; ++$index )
        {
            $accumulator = $xSum;

            // Add weighting term (if applicable).
            if ( NULL !== $weight )
                $accumulator = bcmul( $accumulator, $weight );

            $this->xPowers[ $index ] =
                bcadd( $this->xPowers[ $index ], $accumulator );

            $this->xyPowers[ $index ] =
                bcadd( $this->xyPowers[ $index ], bcmul( $y, $accumulator ) );

            $xSum = bcmul( $xSum, $x );
        }

    } // addData

    /**
     * Get coefficients.
     *
     * Calculate and return coefficients based on current data.
     * @param int $numberOfCoefficient Integer value of the degree polynomial desired.  Default
     *    is -1 which is the max number of coefficients set by class.
     * @return array Array of coefficients (as BC strings).
     */
    public function getCoefficients( $numberOfCoefficient = -1 )
    {
        // If no number of coefficients specified, use standard.
        if ( $numberOfCoefficient == -1 )
            $numberOfCoefficient = $this->numberOfCoefficient;

        // Build a matrix.
        // The matrix is made up of the sum of powers.  So if the number represents the power,
        // the matrix will look like this for a 4th degree polynomial:
        //     [ 0 1 2 3 4 ]
        //     [ 1 2 3 4 5 ]
        //     [ 2 3 4 5 6 ]
        //     [ 3 4 5 6 7 ]
        //     [ 4 5 6 7 8 ]
        //
        $matrix = array();
        for ( $row = 0; $row < $numberOfCoefficient; ++$row )
        {
            $matrix[ $row ] = array();
            for ( $column = 0; $column < $numberOfCoefficient; ++$column )
                $matrix[ $row ][ $column ] =
                    $this->xPowers[ $row + $column ];
        }

        // Create augmented matrix by adding X*Y powers.
        for ( $row = 0; $row < $numberOfCoefficient; ++$row )
            $matrix[ $row ][ $numberOfCoefficient ] = $this->xyPowers[ $row ];

        // Add in the forced coefficients.  This is done by nulling the row and column
        // for each forced coefficient.  For example, a 3th degree polynomial
        // matrix with have the 2nd coefficient set to F:
        //       [ a b c d w ]      [ a 0 c d w ]
        //       [ b c d e x ]  ->  [ 0 1 0 0 F ]
        //       [ c d e f y ]      [ c 0 e f y ]
        //       [ d e f g z ]      [ d 0 f g z ]
        foreach ( $this->forcedValue as $coefficient => $value )
        {
            for ( $index = 0; $index < $numberOfCoefficient; ++$index )
            {
                $matrix[ $index ][ $coefficient ] = "0";
                $matrix[ $coefficient ][ $index ] = "0";
            }

            $matrix[ $coefficient ][ $coefficient ] = "1";
            $matrix[ $coefficient ][ $numberOfCoefficient ] = $value;
        }

        // Determine number of rows in matrix.
        $rows = count( $matrix );

        // Initialize done.
        $isDone = array();
        for ( $column = 0; $column < $rows; ++$column )
            $isDone[ $column ] = false;

        // This loop will result in an upper-triangle matrix with the
        // diagonals all 1--the first part of row-reduction--using 2
        // elementary row operations: multiplying a row by a scalar, and
        // subtracting a row by a multiple of an other row.
        // NOTE: This loop can be done out-of-order.  That is, the first
        // row may not begin with the first term.  Order is tracked in the
        // "order" array.
        $order = array();
        for ( $column = 0; $column < $rows; ++$column )
        {
            // Find a row to work with.
            // A row that has a term in this column, and has not yet been
            // reduced.
            $activeRow = 0;
            while ( ( ( 0 == $matrix[ $activeRow ][ $column ] )
                    || ( $isDone[ $activeRow ] ) )
                && ( $activeRow < $rows ) )
            {
                ++$activeRow;
            }

            // Do we have a term in this row?
            if ( $activeRow < $rows )
            {
                // Remember the order.
                $order[ $column ] = $activeRow;

                // Normalize row--results in the first term being 1.
                $firstTerm = $matrix[ $activeRow ][ $column ];
                for ( $subColumn = $column; $subColumn <= $rows; ++$subColumn )
                    $matrix[ $activeRow ][ $subColumn ] =
                        bcdiv( $matrix[ $activeRow ][ $subColumn ], $firstTerm );

                // This row is finished.
                $isDone[ $activeRow ] = true;

                // Subtract the active row from all rows that are not finished.
                for ( $row = 0; $row < $rows; ++$row )
                    if ( ( ! $isDone[ $row ] )
                        && ( 0 != $matrix[ $row ][ $column ] ) )
                    {
                        // Get first term in row.
                        $firstTerm = $matrix[ $row ][ $column ];
                        for ( $subColumn = $column; $subColumn <= $rows; ++$subColumn )
                        {
                            $accumulator = bcmul( $firstTerm, $matrix[ $activeRow ][ $subColumn ] );
                            $matrix[ $row ][ $subColumn ] =
                                bcsub( $matrix[ $row ][ $subColumn ], $accumulator );
                        }
                    }
            }
        }

        // Reset done.
        for ( $row = 0; $row < $rows; ++$row )
            $isDone[ $row ] = false;

        $coefficients = array();

        // Back-substitution.
        // This will solve the matrix completely, resulting in the identity
        // matrix in the x-locations, and the coefficients in the last column.
        //   | 1  0  0 ... 0  c0 |
        //   | 0  1  0 ... 0  c1 |
        //   | .  .  .     .   . |
        //   | .  .  .     .   . |
        //   | 0  0  0 ... 1  cn |
        for ( $column = ( $rows - 1 ); $column >= 0; --$column )
        {
            // The active row is based on order.
            $activeRow = $order[ $column ];

            // The active row is now finished.
            $isDone[ $activeRow ] = true;

            // For all rows not finished...
            for ( $row = 0; $row < $rows; ++$row )
                if ( ! $isDone[ $row ] )
                {
                    $firstTerm = $matrix[ $row ][ $column ];

                    // Back substitution.
                    for ( $subColumn = $column; $subColumn <= $rows; ++$subColumn )
                    {
                        $accumulator =
                            bcmul( $firstTerm, $matrix[ $activeRow ][ $subColumn ] );
                        $matrix[ $row ][ $subColumn ] =
                            bcsub( $matrix[ $row ][ $subColumn ], $accumulator );
                    }
                }

            // Save this coefficient for the return.
            $coefficients[ $column ] = $matrix[ $activeRow ][ $rows ];
        }

        // Coefficients are stored backward, so sort them.
        ksort( $coefficients );

        // Return the coefficients.
        return $coefficients;

    } // getCoefficients

    /**
     * Interpolate
     *
     * Return y point for given x and coefficient set.  Function is static as it
     * does not require any instance data to operate.
     * @param array $coefficients Coefficients as calculated by 'getCoefficients'.
     * @param float $x X-coordinate from which to calculate Y.
     * @return float Y-coordinate (as floating-point).
     */
    static public function interpolate( $coefficients, $x )
    {
        $numberOfCoefficient = count( $coefficients );

        $y = 0;
        for ( $coefficentIndex = 0; $coefficentIndex < $numberOfCoefficient; ++$coefficentIndex )
        {
            // y += coefficients[ coefficentIndex ] * x^coefficentIndex
            $y =
                bcadd
                (
                    $y,
                    bcmul
                    (
                        $coefficients[ $coefficentIndex ],
                        bcpow( $x, $coefficentIndex )
                    )
                );
        }

        return floatval( $y );

    } // interpolate

    /**
     *  08 August, 2016
     *  Calculate the R-Squared.
     *  R2 shows how well terms (data points) fit a curve or line.
     *
     *  @param array $data
     *  @param array $coefficients
     *  @return float
     *
     *  @author Konstantinos Magarisiotis
     */
    public function RSquared($data = array(), $coefficients = array())
    {
        // Get average of Y-data.
        $Y_Average = 0.0;
        foreach ($data as $dataPoint) {
            $Y_Average += $dataPoint[1];
        }

        $Y_Average /= count($data);

        // Calculate R Squared.
        $Y_MeanSum = 0.0;
        $Y_ErrorSum = 0.0;
        foreach ($data as $dataPoint) {
            $x = $dataPoint[0];
            $y = $dataPoint[1];
            $error = $y;
            $error -= $this->interpolate($coefficients, $x);
            $Y_ErrorSum += $error * $error;

            $error = $y;
            $error -= $Y_Average;
            $Y_MeanSum += $error * $error;
        }

        $R_Squared = 1.0 - ( $Y_ErrorSum / $Y_MeanSum );

        return $R_Squared;
    }

    /**
     *  08 August, 2016
     *  Calculate the 'Adjusted R Squared'.
     *
     *  Adjusted R2 also indicates how well terms fit a curve or line,
     *  but adjusts for the number of terms in a model.
     *  If you add more and more useless variables to a model, adjusted r-squared will decrease.
     *  If you add more useful variables, adjusted r-squared will increase.
     *
     *  http://www.statisticshowto.com/adjusted-r2/
     *  http://blog.minitab.com/blog/adventures-in-statistics/multiple-regession-analysis-use-adjusted-r-squared-and-predicted-r-squared-to-include-the-correct-number-of-variables
     *
     *  @param number $r2
     *  @param number $predictors
     *  @param number $sample_size
     *  @return float
     *
     *  @author Konstantinos Magarisiotis
     */
    public function RAdjusted($r2, $predictors, $sample_size)
    {
        if( ($sample_size - $predictors - 1) != 0 ) {
            $radjusted = 1 - ((1 - $r2) * ($sample_size - 1)) / ($sample_size - $predictors - 1);
        } else {
            $radjusted = 1.0;
        }

        return $radjusted;
    }


} // Class

// "Progress for the tick is not progress for the dog." -- Mencius Moldbug
