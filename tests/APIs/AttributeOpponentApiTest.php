<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AttributeOpponent;

class AttributeOpponentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/attribute-opponents', $attributeOpponent
        );

        $this->assertApiResponse($attributeOpponent);
    }

    /**
     * @test
     */
    public function test_read_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/attribute-opponents/'.$attributeOpponent->id
        );

        $this->assertApiResponse($attributeOpponent->toArray());
    }

    /**
     * @test
     */
    public function test_update_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->create();
        $editedAttributeOpponent = AttributeOpponent::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/attribute-opponents/'.$attributeOpponent->id,
            $editedAttributeOpponent
        );

        $this->assertApiResponse($editedAttributeOpponent);
    }

    /**
     * @test
     */
    public function test_delete_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/attribute-opponents/'.$attributeOpponent->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/attribute-opponents/'.$attributeOpponent->id
        );

        $this->response->assertStatus(404);
    }
}
