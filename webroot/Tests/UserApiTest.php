<?php

require_once(dirname(__FILE__) . '/../vendor/autoload.php');
require_once(dirname(__FILE__) . '/../Class/Database.php');

require_once('config.php');

class UserApiTest extends PHPUnit_Framework_TestCase {
    protected $users_api_url = USERS_API_URL;
	protected $client;
	protected $faker;

    protected static $last_user_id;

    public function __construct() {
        global $last_user_id;
        $last_user_id = null;
    }

    protected function setUp() {
        $this->client = new GuzzleHttp\Client();
        $this->faker = Faker\Factory::create();
    }

    public function testGETUsers() {
        $response = $this->client->get($this->users_api_url);
        $this->assertEquals(200, $response->getStatusCode());

		$data = json_decode($response->getBody(), true);
		$this->assertArrayHasKey('status', $data);
		$this->assertArrayHasKey('data', $data);
		$this->assertEquals(API_STATUS_SUCCESS, $data['status']);
		$this->assertTrue(is_array($data['data']));
    }

    public function testPOST() {
    	$data = array('name' => $this->faker->name, 'picture' => '', 'address' => $this->faker->address);
    	$response = $this->client->post($this->users_api_url,
    		array( 
                'form_params' => $data 
            )
    	);
        $this->assertEquals(200, $response->getStatusCode());

		$data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(API_STATUS_SUCCESS, $data['status']);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('id', $data['data']);
        
        $this->assertGreaterThan(0, $data['data']['id']);

        self::$last_user_id = $data['data']['id'];
    }

    public function testPUT() {
        $id = self::$last_user_id;

    	$data = array('name' => $this->faker->name, 'picture' => '', 'address' => $this->faker->address);
        $response = $this->client->put($this->users_api_url . '/' . $id,
            array( 
                'form_params' => $data 
            )
        );
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(API_STATUS_SUCCESS, $data['status']);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('row_modified', $data['data']);
        
        $this->assertEquals('1', $data['data']['row_modified']);
    }

    public function testGETUser() {
        $id = self::$last_user_id;
        $response = $this->client->get($this->users_api_url . '/' . $id);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals(API_STATUS_SUCCESS, $data['status']);
        $this->assertTrue(is_array($data['data']));
    }

    public function testDELETE() {
    	$id = self::$last_user_id;
        $response = $this->client->delete($this->users_api_url . '/' . $id);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals(API_STATUS_SUCCESS, $data['status']);
        $this->assertTrue(is_array($data['data']));
        $this->assertArrayHasKey('row_deleted', $data['data']);
        $this->assertEquals('1', $data['data']['row_deleted']);
    }

}