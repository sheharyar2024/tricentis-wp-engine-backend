<?php

namespace Tricentis\Api;
use WP_REST_Request;
use WP_REST_Server;

/**
 * Class Roi-Calculator
 * @package Tricentis\Api
 */
class RoiCalculatorApi {

	public const ROUTE_NAMESPACE = 'tricentis/v1';

	public static function initialize(): void {
		add_action( 'rest_api_init', [ __CLASS__, 'addRestEndpointROI' ] );
	}

	public static function addRestEndpointROI(): void {
		
		register_rest_route( self::ROUTE_NAMESPACE, 'roi-calculator', [
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => [ __CLASS__, 'returnOnInvestmentCalculatorOutput' ],
			'permission_callback' => '__return_true',
			'args'                => [
				'id'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'industry'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'automation'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'hours'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'apps'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'releases'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'spend'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
				'revenue'           => [
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => null,
				],
			],
		] );
	}
	public static function returnOnInvestmentCalculatorOutput( WP_REST_Request $request ) {
		
		$id		 		= $request->get_param( 'id' );
		$industry 		= $request->get_param( 'industry' );
		$automation 	= $request->get_param( 'automation' );
		$release_time	= $request->get_param( 'hours' );
		$app_types 		= $request->get_param( 'apps' );
		$releases   	= $request->get_param( 'releases' );
		$spend	 	  	= $request->get_param( 'spend' );
		$revenue	   	= $request->get_param( 'revenue' );

		// Cost of Testing according to input
		if ($spend) {
			$cost_of_testing = $spend;
		} else {
			$cost_of_testing = self::convertRevenueToSpend($revenue, $industry);
		}

		if(strpos($app_types,',') ){
			$app_types = explode(",",$app_types);
		}else{
			$app_types  = array($app_types);
		}
		
		return self::returnOnInvestmentCalculator($id, $industry, $cost_of_testing, $app_types, $automation, $release_time, $releases );
		
	}

	public static function getBaseRiskCoverage($id) {
		return get_field('base_risk_coverage',$id);
	}

	public static function getBaseSpeedIncrease($id) {
		return get_field('base_speed_increase',$id);
	}

	public static function getAcceleratorWeights($id) {
		return get_field('accelerator',$id)[0];
	}

	public static function getIndustryMultipliers($id, $industry) {
		$industry_multiplier = 'ind_mult_' . $industry;
		return get_field($industry_multiplier,$id);
	}

	public static function convertRevenueToSpend($revenue, $industry) {
		switch ( $industry ) {
			case 'financial_services':
				$spend = ( ( $revenue * 0.0716 ) * 0.23 );
				return $spend;
				break;
			case 'consumer':
				$spend = ( ( $revenue * 0.0204 ) * 0.23 );
				return $spend;
				break;
			case 'energy_and_natural_resources':
				$spend = ( ( $revenue * 0.025 ) * 0.23 );
				return $spend;
				break;
			case 'healthcare':
				$spend = ( ( $revenue * 0.0349 ) * 0.23 );
				return $spend;
				break;
			case 'public_service':
				$spend = ( ( $revenue * 0.057 ) * 0.23 );
				return $spend;
				break;
			case 'telecom':
				$spend = ( ( $revenue * 0.0373 ) * 0.23 );
				return $spend;
				break;
			default:
				// Other
				$spend = ( ( $revenue * 0.0328 ) * 0.23 );
				return $spend;
				break;
		}

	}

	public static function getAppTypeMultipliers($id, $app_types) {
		$multipliers_master_array = get_field('app_multipliers',$id);

		if ( in_array( 'sap_on_prem', $app_types ) ) {
			if (($key = array_search('sap_cloud', $app_types)) !== false) {				
				unset($app_types[$key]);
			}
		}
		$filtered_multiplier_array = array();
		foreach ( $app_types as $app_type ) {
			$key = array_search($app_type, array_column($multipliers_master_array, 'acf_fc_layout'));
			$filtered_multiplier_array[] =  $multipliers_master_array[$key];
		}
		return $filtered_multiplier_array;
	}

	public static function getAutomationRateMultipliers($id, $rate) {
		$multipliers_master_array = get_field('automation_rate',$id);
		$filtered_multiplier_array = array();
		$key = array_search($rate, array_column($multipliers_master_array, 'acf_fc_layout'));
		$filtered_multiplier_array[] =  $multipliers_master_array[$key];
		return $filtered_multiplier_array;
	}

	public static function getTimePerReleaseMultiplier( $id, $time_per_release ) {
		$multipliers_master_array = get_field('time_per_release_multiplier', $id);
		
		//take int from user input, use in switch case to get value
		switch ( $time_per_release ) {
			case ($time_per_release < 1000):
				$key = array_search('less_than_1000', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case ($time_per_release < 3000):
				$key = array_search('1000_3000', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case ($time_per_release < 5000):
				$key = array_search('3000_5000', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case ($time_per_release < 10000):
				$key = array_search('5000_10000', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			default:
				$key = array_search('more_than_10000', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
		}
	}

	public static function getNumberOfReleaseMultiplier( $id, $number_of_releases ) {
		$multipliers_master_array = get_field('number_of_releases_multiplier',$id);

		//take int from user input, use in switch case to get value
		switch ( $number_of_releases ) {
			case  1:
				$key = array_search('1', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case 2:
				$key = array_search('2', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case ( $number_of_releases < 5 ):
				$key = array_search('3_4', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case ( $number_of_releases < 9 ):
				$key = array_search('5_8', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			case ( $number_of_releases < 15):
				$key = array_search('9_15', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
				break;
			default:
				$key = array_search('more_than_15', array_column($multipliers_master_array, 'acf_fc_layout'));
				return $multipliers_master_array[$key];
		}
	}

	public static function returnOnInvestmentCalculator($id, $industry, $cost, $app_types, $automation, $release_time, $releases ) {
		// Base Risk Coverage - single val
		$base_risk_coverage = self::getBaseRiskCoverage( $id );
		// Base Speed Increase - single val
		$base_speed_increase = self::getBaseSpeedIncrease( $id );
		// Accelerator Weights - array
		$accelerator_weights = self::getAcceleratorWeights( $id );
		// Industry multipliers - single value per industry, needs industry val passed
		$industry_multiplier = self::getIndustryMultipliers( $id, $industry );
		// Type of App Modifiers - Complex array, keyed by app type, 4 values per app type
		$app_type_multiplier = self::getAppTypeMultipliers( $id, $app_types );
		// Automation Rate Multipliers - Complex array, keyed by rate, 2 values per rate
		$automation_rate_multipliers = self::getAutomationRateMultipliers( $id, $automation );
		// Time Per Release Multipliers - Complex array, keyed by time, 2 values per time
		$time_per_release_multipliers = self::getTimePerReleaseMultiplier( $id, $release_time );
		// Number of Releases Multiplier - Complex array, keyed by release number, 2 values per number
		$number_of_release_multipliers = self::getNumberOfReleaseMultiplier( $id, $releases );

		// Pre-calc Values

		// Type of App values for calc - Keys: cost, speed, quality, accelerator
		$app_type_values[] = self::getAppTypeCalcValues($app_type_multiplier, $accelerator_weights);

		// Automation Rate Multipliers - Keys: cost, speed
		$automation_rate_values[] = self::getAutomationRateCalcValues($automation_rate_multipliers);

		// Time per Release Multipliers - Keys: cost, speed
		$time_per_release_values[] = self::getTimePerReleaseCalcValues($time_per_release_multipliers);

		// Number of Releases Multipliers - Keys: cost, speed
		$number_of_release_values[] = self::getNumberOfReleasesCalcValues($number_of_release_multipliers);

		// Industry Multipliers - single value: quality
		$industry_value = self::getIndustryCalcValues($industry_multiplier);

		$cost_results[] = self::futureCostOfTesting($cost, $automation_rate_values[0]['cost'], $number_of_release_values[0]['cost'], $app_type_values[0]['cost'], $time_per_release_values[0]['cost'], $app_type_values[0]['accelerator'], $accelerator_weights);

		$speed_results[] = self::speedResults( $base_speed_increase, $app_type_values[0]['speed'], $automation_rate_values[0]['speed'], $time_per_release_values[0]['speed'], $number_of_release_values[0]['speed'], $release_time, $releases, $app_type_values[0]['accelerator'], $accelerator_weights, $cost_results[0]['efficiency']['1_year']);

		$quality_results[] = self::qualityResults( $base_risk_coverage ,$app_type_values[0]['quality'], $industry_value, $app_type_values[0]['accelerator'], $accelerator_weights);

		$calc_results['cost'] = $cost_results;
		$calc_results['speed'] = $speed_results;
		$calc_results['quality'] = $quality_results;

		return $calc_results;
	}

	public static function qualityResults($base_risk, $app_quality, $industry_quality, $app_accelerator, $accelerator_weights) {
		$risk_reduction_base = ( $base_risk * $app_quality * $industry_quality ) / 100;

		$risk_reduction['6_months'] = $risk_reduction_base * $app_accelerator;
		$risk_reduction['1_year'] = $risk_reduction_base * $accelerator_weights['1_year'];
		$risk_reduction['2_years'] = $risk_reduction_base * $accelerator_weights['2_years'];
		$risk_reduction['3_years'] = $risk_reduction_base * $accelerator_weights['3_years'];

		$defects['6_months'] = self::calcDefects($risk_reduction['6_months']);
		$defects['1_year'] = self::calcDefects($risk_reduction['1_year']);
		$defects['2_years'] = self::calcDefects($risk_reduction['2_years']);
		$defects['3_years'] = self::calcDefects($risk_reduction['3_years']);

		$quality_results['risk'] = $risk_reduction;
		$quality_results['defects'] = $defects;

		return $quality_results;
	}

	public static function calcDefects($risk) {
		return round (( ( $risk * 100 ) * ( $risk * 100 ) * 0.0033053125 + ( $risk * 100 ) * -0.65553125 + 32.5), 3);
	}

	public static function speedResults( $base_speed ,$app_speed, $automation_speed, $release_time_speed, $release_number_speed, $release_time, $releases, $app_accelerator, $accelerator_weights, $efficiency ) {
		$efficiency_modifier = $efficiency / 100;
		$test_speed_base = round( ( $base_speed * $app_speed * $automation_speed * $release_time_speed * $release_number_speed), 0);
		$days_saved_base = round( ( ( ( $release_time * $releases ) * $efficiency_modifier ) / 8), 0);

		$testing_cycles['6_months'] = round( ( $test_speed_base * $app_accelerator ), 0 );
		$testing_cycles['1_year'] = round( ( $test_speed_base * $accelerator_weights['1_year'] ), 0 );
		$testing_cycles['2_years'] = round( ( $test_speed_base * $accelerator_weights['2_years'] ), 0 );
		$testing_cycles['3_years'] = round( ( $test_speed_base * $accelerator_weights['3_years'] ), 0 );

		$days_saved['6_months'] = $days_saved_base * $app_accelerator;
		$days_saved['1_year'] = $days_saved_base * $accelerator_weights['1_year'];
		$days_saved['2_years'] = ( $days_saved_base * $accelerator_weights['2_years'] ) + $days_saved['1_year'];
		$days_saved['3_years'] = ( $days_saved_base * $accelerator_weights['3_years'] ) + $days_saved['2_years'];

		$speed_results['cycles'] = $testing_cycles;
		$speed_results['days'] = $days_saved;

		return $speed_results;
	}

	public static function futureCostOfTesting($cost, $automate_cost, $release_number_cost, $industry_cost, $release_time_cost, $app_accelerator, $accelerator_weights) {

		$cost_modifiers = $automate_cost + $release_number_cost + $industry_cost + $release_time_cost;
		$base_future_cost = $cost * (1 - $cost_modifiers);
		$future_cost_six_mo = $cost * ( 1 - ( $app_accelerator * $cost_modifiers ));
		$future_cost_one_year = $base_future_cost * $accelerator_weights['1_year'];
		$future_cost_two_year = $future_cost_one_year + ($base_future_cost * $accelerator_weights['2_years']);
		$future_cost_three_year = $future_cost_two_year + ($base_future_cost * $accelerator_weights['3_years']);

		$cost_savings['6_months'] = $cost - $future_cost_six_mo;
		$cost_savings['1_year'] = $cost - $future_cost_one_year;
		$cost_savings['2_years'] = ( $cost * 2 ) - $future_cost_two_year;
		$cost_savings['3_years'] = ( $cost * 3 ) - $future_cost_three_year;

		$efficiency_gain['6_months'] = 100 * round( ( $cost_savings['6_months'] / $cost ), 2);
		$efficiency_gain['1_year'] = 100 * round( ($cost_savings['1_year'] / $cost ), 2);
		$efficiency_gain['2_years'] = 100 * round( ($cost_savings['2_years'] / ( $cost * 2 ) ), 2);
		$efficiency_gain['3_years'] = 100 * round( ($cost_savings['3_years'] / ( $cost * 3 ) ), 2);

		$cost_results['efficiency'] = $efficiency_gain;
		$cost_results['savings'] = $cost_savings;

		return $cost_results;
	}

	public static function getAppTypeCalcValues($multipliers, $accelerators) {
		$app_type_calc['cost'] = 0;
		$app_type_calc['speed'] = 1;
		$app_type_calc['quality'] = 1;
		$app_type_calc['accelerator'] = 1;
		foreach ($multipliers as $multiplier) {
			$app_type_calc['cost'] += $multiplier['cost'];
			$app_type_calc['speed'] += $multiplier['speed'];
			$app_type_calc['quality'] += $multiplier['quality'];
			$app_type_calc['accelerator'] += $multiplier['accelerator'];
		}
		$app_type_calc['accelerator'] *= $accelerators['6_months'];
		return $app_type_calc;
	}

	public static function getAutomationRateCalcValues($automation) {
		$automation_calc['cost'] = floatval($automation[0]['cost']);
		$automation_calc['speed'] = 1 + $automation[0]['speed'];
		return $automation_calc;
	}

	public static function getTimePerReleaseCalcValues($time) {
		$time_calc['cost'] = floatval($time['cost']);
		$time_calc['speed'] = 1 + $time['speed'];
		return $time_calc;
	}

	public static function getNumberOfReleasesCalcValues($number) {
		$number_calc['cost'] = floatval($number['cost']);
		$number_calc['speed'] = 1 + $number['speed'];
		return $number_calc;
	}

	public static function getIndustryCalcValues($industry) {
		$industry_calc = 1 + $industry;
		return $industry_calc;
	}


}

RoiCalculatorApi::initialize();

