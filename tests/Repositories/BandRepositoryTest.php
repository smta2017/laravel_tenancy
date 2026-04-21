<?php

namespace Tests\Repositories;

use App\Models\Band;
use App\Repositories\BandRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BandRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected BandRepository $bandRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bandRepo = app(BandRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_band()
    {
        $band = Band::factory()->make()->toArray();

        $createdBand = $this->bandRepo->create($band);

        $createdBand = $createdBand->toArray();
        $this->assertArrayHasKey('id', $createdBand);
        $this->assertNotNull($createdBand['id'], 'Created Band must have id specified');
        $this->assertNotNull(Band::find($createdBand['id']), 'Band with given id must be in DB');
        $this->assertModelData($band, $createdBand);
    }

    /**
     * @test read
     */
    public function test_read_band()
    {
        $band = Band::factory()->create();

        $dbBand = $this->bandRepo->find($band->id);

        $dbBand = $dbBand->toArray();
        $this->assertModelData($band->toArray(), $dbBand);
    }

    /**
     * @test update
     */
    public function test_update_band()
    {
        $band = Band::factory()->create();
        $fakeBand = Band::factory()->make()->toArray();

        $updatedBand = $this->bandRepo->update($fakeBand, $band->id);

        $this->assertModelData($fakeBand, $updatedBand->toArray());
        $dbBand = $this->bandRepo->find($band->id);
        $this->assertModelData($fakeBand, $dbBand->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_band()
    {
        $band = Band::factory()->create();

        $resp = $this->bandRepo->delete($band->id);

        $this->assertTrue($resp);
        $this->assertNull(Band::find($band->id), 'Band should not exist in DB');
    }
}
