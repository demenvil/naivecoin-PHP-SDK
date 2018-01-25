<?php

/*
 *
 * Copyright 2017 Ghislain Ott - ghislain.ott@gmail.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * http://:3001/blockchain/blocks
 */

class Naivecoin {

 private $base_api;
 private $host_api;
 private $port = "3001";
 public $headers = array(
	 'Accept: application/json',
	 'Content-Type: application/json; charset=utf-8'
 );

 const method_api = "POST";
 const scheme = "http";

 /**
	* 
	* @param string $host_api
	* @param int $port
	*/
 public function __construct(string $host_api, int $port) {
	$this->__set('port', $port);
	$this->__set('host_api', $host_api);
 }

 /**
	* 
	* @param string $property
	* @param type $value
	* @return $this
	*/
 public function __set(string $property, $value) {
	$this->$property = $value;
	return $this;
 }

 /**
	* 
	* @param string $method
	* @param string $path
	* @param type $args
	* @param type $content
	* @return type
	* @throws Exception
	*/
 private function _call(string $method, string $path, $args = array(), $content = null) {
	if (!in_array($method, array('GET', 'POST', 'PUT')))
	 throw new Exception('Method is not allowed', 405);

	if (substr($path, 0, 1) != '/')
	 $path = '/' . $path;
	if ($path == '/')
	 throw new Exception('Endpoint is missing', 400);

	$url = self::scheme . "://" . $this->host_api . ':' . $this->port . $path;
	if ($args)
	 $url .= '?' . implode('&', $this->flatten($args));
	$h = curl_init();
	curl_setopt($h, CURLOPT_URL, $url);
	if ($content)
	 curl_setopt($h, CURLOPT_POSTFIELDS, json_encode($content, true));
	curl_setopt($h, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($h, CURLOPT_PORT, $this->port);
	curl_setopt($h, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($h, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($h, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($h, CURLOPT_VERBOSE, 0);
	switch ($method) {
	 case 'GET' : break;
	 case 'POST' :
		curl_setopt($h, CURLOPT_POST, true);
		break;
	 case 'PUT' :
		curl_setopt($h, CURLOPT_CUSTOMREQUEST, 'PUT');
		break;
	}

	$response = curl_exec($h);
// echo "DEBUG";
// echo $response;
	$error = curl_error($h);
	$code = (int) curl_getinfo($h, CURLINFO_HTTP_CODE);
	curl_close($h);

	if ($error)
	 throw new Exception('Client error : ' . $error);

	if ($code < 200 || $code > 299) {
	 if (($method != 'POST') || ($code != 201)) {
		throw new Exception('Http error ' . $code . ($response ? ' : ' . $response : ''));
	 }
	}

	if (!$response)
	 throw new Exception('Empty response');

	return json_decode($response, true);
 }

 /**
	* 
	* @param type $a
	* @param type $p
	* @return string
	*/
 private function flatten($a, $p = null) {
	$o = array();
	ksort($a);
	foreach ($a as $k => $v) {
	 if (is_array($v)) {
		foreach ($this->flatten($v, $p ? $p . '[' . $k . ']' : $k) as $s)
		 $o[] = $s;
	 } else
		$o[] = ($p ? $p . '[' . $k . ']' : $k) . '=' . $v;
	}
	return $o;
 }

 /**
	* 
	* @return type
	*/
 public function getAllBlock() {
	$response = $this->_call('GET', 'blockchain/blocks', null, null);
	return $response;
 }

 /**
	* 
	* @return type
	*/
 public function getLatestBlock() {
	$response = $this->_call('GET', 'blockchain/blocks/latest', null, null);
	return $response;
 }

 /**
	* 
	* @param int $index
	* @return type
	*/
 public function getBlockByIndex(int $index) {
	$response = $this->_call('GET', 'blockchain/blocks/' . $index, null, null);
	return $response;
 }

 /**
	* 
	* @param string $hash
	* @return type
	*/
 public function getBlockByHash(string $hash) {
	$response = $this->_call('GET', 'blockchain/blocks/' . $hash, null, null);
	return $response;
 }

 /**
	* 
	* @param string $transactionId
	* @return type
	*/
 public function getBlockByTransactionsId(string $transactionId) {
	$response = $this->_call('GET', 'blockchain/blocks/transactions/' . $transactionId, null, null);
	return $response;
 }

 /**
	* 
	* @return type
	*/
 public function getAllTransaction() {
	$response = $this->_call('GET', 'blockchain/transactions', null, null);
	return $response;
 }

 /**
	* 
	* @return type
	*/
 public function getUnspentTransactions() {
	$response = $this->_call('GET', 'blockchain/transactions/unspent', null, null);
	return $response;
 }

 /**
	* 
	* @return type
	*/
 public function getAllWallets() {
	$response = $this->_call('GET', 'operator/wallets', null, null);
	return $response;
 }

 /**
	* 
	* @param type $password
	* @return type
	*/
 public function createWallet(string $password) {
	$response = $this->_call('POST', 'operator/wallets', null, array(
		'password' => $password,
	));
	return $response;
 }

 /**
	* 
	* @param type $walletId
	* @return type
	*/
 public function getWalletById(string $walletId) {
	$response = $this->_call('GET', 'operator/wallets/' . $walletId, null, null);
	return $response;
 }

 /**
	* 
	* @param type $walletId
	* @return type
	*/
 public function getAllAdresseOfWallet(string $walletId) {

	$response = $this->_call('GET', 'operator/wallets/' . $walletId . '/addresses', null, null);
	return $response;
 }

 /**
	* 
	* @param type $password
	* @param type $walledId
	* @return type
	*/
 public function createAddress(string $password, string $walledId) {
	array_push($this->headers, 'password:' . $password . '');
	$response = $this->_call('POST', 'operator/wallets/' . $walledId . '/addresses', null, null);
	return $response;
 }

 /**
	* 
	* @param string $walletId
	* @param string $password
	* @param string $from
	* @param string $to
	* @param int $amount
	* @return type
	*/
 public function withdrawal(string $walletId, string $password, string $from, string $to, int $amount) {
	array_push($this->headers, 'password:' . $password . '');
//	die();
	$response = $this->_call('POST', 'operator/wallets/' . $walletId . '/transactions', array(
		"password" => $password,
		), array(
		'fromAddress' => $from,
		'toAddress' => $to,
		'amount' => $amount,
		'password' => $password
	));
	return $response;
 }

 /**
	* 
	* @param type $addressId
	* @return type
	*/
 public function getBalance($addressId) {
	$response = $this->_call('GET', 'operator/' . $addressId . '/balance', null, null);
	return $response;
 }

 /**
	* 
	* @return type
	*/
 public function getAllpeers() {
	$response = $this->_call('GET', 'node/peers', null, null);
	return $response;
 }

 /**
	* 
	* @param string $url
	* @return type
	*/
 public function connectNewPeer(string $url) {
	$response = $this->_call('POST', 'node/peers', null, array(
		'url' => $url,
	));
	return $response;
 }

 /**
	* 
	* @param string $transactionId
	* @return type
	*/
 public function getConfirmation(string $transactionId) {
	$response = $this->_call('GET', 'node/transactions/' . $transactionId . '/confirmations', null, null);
	return $response;
 }

}
