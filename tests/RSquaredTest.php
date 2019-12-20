<?php

use DrQue\PolynomialRegression;

class RSquaredTest extends \PHPUnit\Framework\TestCase
{
	public function testRsquared()
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
		
		
		$rsquared = $leastSquareRegression->RSquared($data, $coefficients);
		
		$this->assertEqualsWithDelta(0.926, $rsquared, 0.001);
	}
	
	
	
	public function testRsquaredAdjusted()
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
	
	
		$rsquared = $leastSquareRegression->RSquared($data, $coefficients);
		
		$radjusted = $leastSquareRegression->RAdjusted($rsquared, 1, count($data));
	
		$this->assertEqualsWithDelta(0.924, $radjusted, 0.001);
	}
	
}

?>
