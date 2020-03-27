<?php

namespace Alfanjauhari\Crovid;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Crovid
{
	/**
	 * Get api url
	 * @var string 
	 */
	protected $api;

	/**
	 * Crovid construct
	 */
	public function __construct()
	{
		$this->api = 'https://api.kawalcorona.com/';
	}

	/**
	 * Mendapatkan data COVID-19 secara global
	 * 
	 * @param string|null $options
	 * @param array $headers
	 * @return mixed
	 */
	public function getGlobalData(string $options = null, array $headers = ['Content-Type' => 'application/json'])
	{
		try {
			if(! is_null($options)) {
				switch ($options) {
					case 'Confirmed':
					case 'confirmed':
					case 'Positif':
					case 'positif':
						$getContent = collect(Http::get($this->api . 'positif')->json());
						$data = $getContent->only('value');
						$data['Confirmed'] = $data['value'];
						unset($data['value']);
						return response()->json($data)->withHeaders($headers);
						break;
					
					case 'Deaths':
					case 'deaths':
					case 'Meninggal':
					case 'meninggal':
						$getContent = collect(Http::get($this->api . 'meninggal')->json());
						$data = $getContent->only('value');
						$data['Deaths'] = $data['value'];
						unset($data['value']);
						return response()->json($data)->withHeaders($headers);
						break;

					case 'Recovered':
					case 'recovered':
					case 'Sembuh':
					case 'sembuh':
						$getContent = collect(Http::get($this->api . 'sembuh')->json());
						$data = $getContent->only('value');
						$data['Recovered'] = $data['value'];
						unset($data['value']);
						return response()->json($data)->withHeaders($headers);
						break;

					default:
						abort(404, 'Sorry, Please Input Your Query Correctly!');
						break;
				}
			} elseif(is_null($options)) {
				$getContent = collect(Http::get($this->api)->json());
				$data = $getContent->flatten(1);
				return response()->json($data)->withHeaders($headers);
			} else {
				abort(500, 'Something Went Wrong!');	
			}
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Mendapatkan data COVID-19 di salah satu negara yang terdampak
	 * 
	 * @param string|null $country
	 * @param string|null $options
	 * @param array $headers
	 * @return mixed
	 */
	public function getCountriesData(string $country = null, string $options = null, array $headers = ['Content-Type' => 'application/json'])
	{
		try {
			$getContent = collect(Http::get($this->api)->json());
			$data = $getContent->flatten(1);
			if (! is_null($country)) {
				$countryData = $data->filter(function($element) use ($country) {
					return false !== stripos($element['Country_Region'], $country);
				})->first();
				if($countryData) {
					if(! is_null($options)) {
						switch ($options) {
							case 'Confirmed':
							case 'confirmed':
							case 'Positif':
							case 'positif':
								$getCase[$countryData['Country_Region'] . '_Confirmed'] = $countryData['Confirmed'];
								return response()->json($getCase)->withHeaders($headers);
								break;
							
							case 'Deaths':
							case 'deaths':
							case 'Meninggal':
							case 'meninggal':
								$getCase[$countryData['Country_Region'] . '_Deaths'] = $countryData['Deaths'];
								return response()->json($getCase)->withHeaders($headers);
								break;

							case 'Recovered':
							case 'recovered':
							case 'Sembuh':
							case 'sembuh':
								$getCase[$countryData['Country_Region'] . '_Recovered'] = $countryData['Recovered'];
								return response()->json($getCase)->withHeaders($headers);
								break;

							default:
								abort(404, 'Sorry, Please Input Your Query Correctly!');
								break;
						}
					} elseif(is_null($options)) {
						return response()->json($countryData)->withHeaders($headers);
					} else {
						abort(500, 'Something Went Wrong!');
					}
				} elseif(! $countryData) {
					abort(404, 'Sorry, the Country You are For Looking Doesn\'t Exists');
				} else {
					abort(500, 'Something Went Wrong!');
				}
			} elseif(is_null($country)) {
				$getCountry = Arr::pluck($data, 'Country_Region');
				return response()->json($getCountry);
			} else {
				abort(500, 'Something Went Wrong!');
			}
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Mendapatkan data COVID-19 di Indonesia
	 * 
	 * @param string|null $options
	 * @param array $headers
	 * @return mixed
	 */
	public function getIndonesiaData(string $options = null, array $headers = ['Content-Type' => 'application/json'])
	{
		try {
			$getContent = collect(Http::get($this->api . 'indonesia')->json());
			if(! is_null($options)) {
				switch ($options) {
					case 'Confirmed':
					case 'confirmed':
					case 'Positif':
					case 'positif':
						$getCase['Indonesia_Confirmed'] = $getContent[0]['positif'];
						return response()->json($getCase)->withHeaders($headers);
						break;
					
					case 'Deaths':
					case 'deaths':
					case 'Meninggal':
					case 'meninggal':
						$getCase['Indonesia_Deaths'] = $getContent[0]['meninggal'];
						return response()->json($getCase)->withHeaders($headers);
						break;

					case 'Recovered':
					case 'recovered':
					case 'Sembuh':
					case 'sembuh':
						$getCase['Indonesia_Recovered'] = $getContent[0]['sembuh'];
						return response()->json($getCase)->withHeaders($headers);
						break;

					default:
						abort(404, 'Sorry, Please Input Your Query Correctly!');
						break;
				}
			} elseif(is_null($options)) {
				return response()->json($getContent)->withHeaders($headers);
			} else {
				abort(500, 'Something Went Wrong!');
			}
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Mendapatkan data COVID-19 setiap provinsi di Indonesia
	 * 
	 * @param string|null $provinsi
	 * @param string|null $options
	 * @param array $headers
	 * @return mixed
	 */
	public function getProvinsiData(string $provinsi = null, string $options = null, array $headers = ['Content-Type' => 'application/json'])
	{
		try {
			$getContent = collect(Http::get($this->api . 'indonesia/provinsi')->json());
			$data = $getContent->flatten(1);
			if(! is_null($provinsi)) {
				$provinsiData = $data->filter(function($element) use ($provinsi) {
					return false !== stripos($element['Provinsi'], $provinsi);
				})->first();
				if($provinsiData) {
					if(! is_null($options)) {
						switch ($options) {
							case 'Confirmed':
							case 'confirmed':
							case 'Positif':
							case 'positif':
								$getCase[$provinsiData['Provinsi'] . '_Confirmed'] = $provinsiData['Kasus_Posi'];
								return response()->json($getCase)->withHeaders($headers);
								break;
							
							case 'Deaths':
							case 'deaths':
							case 'Meninggal':
							case 'meninggal':
								$getCase[$provinsiData['Provinsi'] . '_Deaths'] = $provinsiData['Kasus_Meni'];
								return response()->json($getCase)->withHeaders($headers);
								break;

							case 'Recovered':
							case 'recovered':
							case 'Sembuh':
							case 'sembuh':
								$getCase[$provinsiData['Provinsi'] . '_Recovered'] = $provinsiData['Kasus_Semb'];
								return response()->json($getCase)->withHeaders($headers);
								break;

							default:
								abort(404, 'Sorry, Please Input Your Query Correctly!');
								break;
						}
					} elseif(is_null($options)) {
						return response()->json($provinsiData)->withHeaders($headers);
					} else {
						abort(500, 'Something Went Wrong!');
					}
				} elseif(! $provinsiData) {
					abort(404, 'Sorry, Provinsi Not Found!');
				} else {
					abort(500, 'Something Went Wrong!');
				}
			} elseif(is_null($provinsi)) {
				$provinsiData = Arr::pluck($data, 'Provinsi');
				return response()->json($provinsiData);
			} else {
				abort(500, 'Something Went Wrong!');
			}
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}
}