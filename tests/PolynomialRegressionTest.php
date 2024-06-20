<?php

namespace DrQue\PolynomialRegression\Tests;

use DrQue\PolynomialRegression;
use PHPUnit\Framework\TestCase;

class PolynomialRegressionTest extends TestCase
{
    
    public function testSetNumberOfCoefficent()
    {
        $polynomialRegression = new PolynomialRegression(4);
        $polynomialRegression->setNumberOfCoefficient(2);
        
        $this->assertEquals(2, $polynomialRegression->getNumberOfCoefficient());
        
        $polynomialRegression->setDegree(3);
        
        $this->assertEquals(3, $polynomialRegression->getNumberOfCoefficient());
    }

    public function testLinearRegression()
    {
        $data = array(
            array(0.00, 27.3834562958158), array(0.02, 38.2347360741764),
            array(0.04, 42.5632501679666), array(0.06, 19.4638760104114),
            array(0.08, 42.690858098909), array(0.10, 25.330634164557),
            array(0.12, 49.6507591632989), array(0.14, 34.3502467856792),
            array(0.16, 52.5267153107089), array(0.18, 34.5528919545231),
            array(0.20, 44.3220950255077), array(0.22, 44.7805694031715),
            array(0.24, 32.9090525820585), array(0.26, 56.7941323051778),
            array(0.28, 48.7192221569495), array(0.30, 48.7964850888813),
            array(0.32, 56.8905173101315), array(0.34, 66.0107252116092),
            array(0.36, 74.3149331561425), array(0.38, 52.9076168019644),
            array(0.40, 64.3463647026162), array(0.42, 50.0776706625628),
            array(0.44, 62.3527806092493), array(0.46, 75.9589658430523),
            array(0.48, 69.280743962744), array(0.50, 74.4868159870338),
            array(0.52, 76.4548504742096), array(0.54, 82.9347555390181),
            array(0.56, 83.9546576353049), array(0.58, 83.6379624022705),
            array(0.60, 92.6278811310654), array(0.62, 84.3395153143048),
            array(0.64, 86.832363003336), array(0.66, 105.66563124607),
            array(0.68, 100.175129109663), array(0.70, 82.0781941886623),
            array(0.72, 95.9916212989616), array(0.74, 87.5853932119967),
            array(0.76, 93.5435091554247), array(0.78, 98.0622114645327),
            array(0.80, 118.067000253198), array(0.82, 98.2918886287489),
            array(0.84, 111.027863906934), array(0.86, 113.1135947538),
            array(0.88, 117.777915259186), array(0.90, 108.621331147219),
            array(0.92, 112.979639159754), array(0.94, 122.065499190418),
            array(0.96, 116.136221596622), array(0.98, 111.215762010712),
            array(1.00, 122.743302375187)
        );

        // Precision digits in BC math. 
        bcscale(10);

        // Start a regression class of order 2--linear regression. 
        $PolynomialRegression = new PolynomialRegression(2);

        // Add all the data to the regression analysis. 
        foreach ($data as $dataPoint) {
            $PolynomialRegression->addData($dataPoint[0], $dataPoint[1]);
        }

        // Get coefficients for the polynomial. 
        $coefficients = $PolynomialRegression->getCoefficients();
        
        $this->assertEquals(2, $PolynomialRegression->getNumberOfCoefficient());
        $this->assertEquals(95.75, round($coefficients[1], 2));
        $this->assertEquals(26.55, round($coefficients[0], 2));
    }

    public function testThirdDegreePolynomial()
    {
        // Data created in a spreadsheet with some random scatter.  True function should be: 
        //   f( x ) = 0.65 + 0.6 x - 6.25 x^2 + 6 x^3 
        $data = array(
            array(0.00, 0.65646507), array(0.05, 0.61435503),
            array(0.10, 0.63151965), array(0.15, 0.57711365),
            array(0.20, 0.58534249), array(0.25, 0.54148715),
            array(0.30, 0.43877649), array(0.35, 0.39516968),
            array(0.40, 0.24977940), array(0.45, 0.24246690),
            array(0.50, 0.07730788), array(0.55, 0.03633931),
            array(0.60, 0.08980716), array(0.65, 0.07562991),
            array(0.70, 0.11196788), array(0.75, 0.15086596),
            array(0.80, 0.19979455), array(0.85, 0.34683801),
            array(0.90, 0.48338650), array(0.95, 0.59196113),
            array(1.00, 0.99233320)
        );

        // Precision digits in BC math. 
        bcscale(10);

        // Start a regression class with a maximum of 4rd degree polynomial. 
        $polynomialRegression = new PolynomialRegression(4);

        // Add all the data to the regression analysis. 
        foreach ($data as $dataPoint) {
            $polynomialRegression->addData($dataPoint[0], $dataPoint[1]);
        }

        $coefficients = $polynomialRegression->getCoefficients();

        $this->assertEquals(4, $polynomialRegression->getNumberOfCoefficient());
        $this->assertEquals(0.63, round($coefficients[0], 2));
        $this->assertEquals(0.60, round($coefficients[1], 2));
        $this->assertEquals(-5.97, round($coefficients[2], 2));
        $this->assertEquals(5.68, round($coefficients[3], 2));
    }

    public function testCalculatingRSquared()
    {

        $data = array(
            array(0.00, 27.3834562958158), array(0.02, 38.2347360741764),
            array(0.04, 42.5632501679666), array(0.06, 19.4638760104114),
            array(0.08, 42.690858098909), array(0.10, 25.330634164557),
            array(0.12, 49.6507591632989), array(0.14, 34.3502467856792),
            array(0.16, 52.5267153107089), array(0.18, 34.5528919545231),
            array(0.20, 44.3220950255077), array(0.22, 44.7805694031715),
            array(0.24, 32.9090525820585), array(0.26, 56.7941323051778),
            array(0.28, 48.7192221569495), array(0.30, 48.7964850888813),
            array(0.32, 56.8905173101315), array(0.34, 66.0107252116092),
            array(0.36, 74.3149331561425), array(0.38, 52.9076168019644),
            array(0.40, 64.3463647026162), array(0.42, 50.0776706625628),
            array(0.44, 62.3527806092493), array(0.46, 75.9589658430523),
            array(0.48, 69.280743962744), array(0.50, 74.4868159870338),
            array(0.52, 76.4548504742096), array(0.54, 82.9347555390181),
            array(0.56, 83.9546576353049), array(0.58, 83.6379624022705),
            array(0.60, 92.6278811310654), array(0.62, 84.3395153143048),
            array(0.64, 86.832363003336), array(0.66, 105.66563124607),
            array(0.68, 100.175129109663), array(0.70, 82.0781941886623),
            array(0.72, 95.9916212989616), array(0.74, 87.5853932119967),
            array(0.76, 93.5435091554247), array(0.78, 98.0622114645327),
            array(0.80, 118.067000253198), array(0.82, 98.2918886287489),
            array(0.84, 111.027863906934), array(0.86, 113.1135947538),
            array(0.88, 117.777915259186), array(0.90, 108.621331147219),
            array(0.92, 112.979639159754), array(0.94, 122.065499190418),
            array(0.96, 116.136221596622), array(0.98, 111.215762010712),
            array(1.00, 122.743302375187)
        );

        // Precision digits in BC math. 
        bcscale(10);

        // Start a regression class of order 2--linear regression. 
        $leastSquareRegression = new PolynomialRegression(2);

        // Add all the data to the regression analysis. 
        foreach ($data as $dataPoint) {
            $leastSquareRegression->addData($dataPoint[0], $dataPoint[1]);
        }

        // Get coefficients for the polynomial. 
        $coefficients = $leastSquareRegression->getCoefficients();

        // 
        // Get average of Y-data. 
        // 
        $Y_Average = 0.0;
        foreach ($data as $dataPoint)
            $Y_Average += $dataPoint[1];

        $Y_Average /= count($data);

        // 
        // Calculate R Squared. 
        // 

        $Y_MeanSum = 0.0;
        $Y_ErrorSum = 0.0;
        foreach ($data as $dataPoint) {
            $x = $dataPoint[0];
            $y = $dataPoint[1];
            $error = $y;
            $error -= $leastSquareRegression->interpolate($coefficients, $x);
            $Y_ErrorSum += $error * $error;

            $error = $y;
            $error -= $Y_Average;
            $Y_MeanSum += $error * $error;
        }

        $R_Squared = 1.0 - ( $Y_ErrorSum / $Y_MeanSum );

        $this->assertEquals(0.93, round($R_Squared, 2));
    }

    public function testLinearRegressionWithForcedIntercept()
    {
        $data = array(
            array(0.05, 0.1924787314), array(0.10, 0.4586186921),
            array(0.15, 0.1318838557), array(0.20, 0.1865927433),
            array(0.25, 0.4667421897), array(0.30, 0.1027880072),
            array(0.35, 0.5599968985), array(0.40, 0.6605423892),
            array(0.45, 0.620103306), array(0.50, 0.4445367125),
            array(0.55, 0.5912679423), array(0.60, 0.7942020837),
            array(0.65, 0.8694575373), array(0.70, 0.4146043937),
            array(0.75, 0.6604661468), array(0.80, 0.9138025779),
            array(0.85, 0.8124334151), array(0.90, 0.7998087715),
            array(0.95, 0.7391285236), array(1.00, 0.9012208138),
        );

        // Precision digits in BC math. 
        bcscale(10);

        // Start a regression class of order 4, one with no forcing coefficients, 
        // one with two forced coefficients. 
        $regression1 = new PolynomialRegression(2);
        $regression2 = new PolynomialRegression(2);
        $regression2->setForcedCoefficient(0, 0);

        // Add all the data to both regression analysis. 
        foreach ($data as $dataPoint) {
            $regression1->addData($dataPoint[0], $dataPoint[1]);
            $regression2->addData($dataPoint[0], $dataPoint[1]);
        }

        // Get coefficients for the polynomial. 
        $coefficients1 = $regression1->getCoefficients();
        $coefficients2 = $regression2->getCoefficients();

        $this->assertEquals(0.19, round($coefficients1[0], 2));
        $this->assertEquals(0.71, round($coefficients1[1], 2));
        $this->assertEquals(0.00, round($coefficients2[0], 2));
        $this->assertEquals(0.99, round($coefficients2[1], 2));
    }

    public function testForcedCoefficients()
    {
        $data = array(
            array(0.00, 0.65379741), array(0.05, 0.64074062),
            array(0.10, 0.72833783), array(0.15, 0.44629689),
            array(0.20, 0.45174500), array(0.25, 0.34161602),
            array(0.30, 0.78621158), array(0.35, 0.38960121),
            array(0.40, 0.14126441), array(0.45, 0.38123106),
            array(0.50, 0.20605429), array(0.55, 0.02456525),
            array(0.60, 0.48434811), array(0.65, 0.21453304),
            array(0.70, 0.54765807), array(0.75, 0.41625294),
            array(0.80, 0.78163483), array(0.85, 0.71306009),
            array(0.90, 0.53515664), array(0.95, 0.98918384),
            array(1.00, 0.93061202)
        );

        // The actual coefficients for the above data (without noise). 
        $trueCoefficients = array(0.9, -2, 0.6, 1.5);

        // Precision digits in BC math. 
        bcscale(10);

        // Start a regression class of order 4, one with no forcing coefficients, 
        // one with two forced coefficients. 
        $regression1 = new PolynomialRegression(4);
        $regression2 = new PolynomialRegression(4);
        $regression2->setForcedCoefficient(1, -2);
        $regression2->setForcedCoefficient(3, 1.5);
        
        
        $this->assertEquals(-2, $regression2->getForcedCoefficient(1));
        $this->assertEquals(1.5, $regression2->getForcedCoefficient(3));
        

        // Add all the data to both regression analysis. 
        foreach ($data as $dataPoint) {
            $regression1->addData($dataPoint[0], $dataPoint[1]);
            $regression2->addData($dataPoint[0], $dataPoint[1]);
        }

        // Get coefficients for the polynomial. 
        $coefficients1 = $regression1->getCoefficients();
        $coefficients2 = $regression2->getCoefficients();
        
        $this->assertEquals(0.72, round($coefficients1[0], 2));
        $this->assertEquals(-1.30, round($coefficients1[1], 2));
        $this->assertEquals(0.35, round($coefficients1[2], 2));
        $this->assertEquals(1.25, round($coefficients1[3], 2));
        
        $this->assertEquals(0.86, round($coefficients2[0], 2));
        $this->assertEquals(-2.00, round($coefficients2[1], 2));
        $this->assertEquals(0.76, round($coefficients2[2], 2));
        $this->assertEquals(1.50, round($coefficients2[3], 2));
    }

}
