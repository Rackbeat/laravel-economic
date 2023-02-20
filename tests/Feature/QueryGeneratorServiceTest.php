<?php

use Tests\TestCase;

use LasseRafn\Economic\Services\QueryGeneratorService;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QueryGeneratorServiceTest extends TestCase
{
    /** @var array */
    private $filters;

    /** @var array */
    private $sorts;

    public function setUp(): void
    {
        parent::setUp();

        $this->filters[] = [ 'lastUpdated', '>=', '2023-02-15' ];

        $this->sorts = ['-orderNumber'];
    }

    /** @test */
    public function will_correctly_add_filter_string()
    {
      $this->assertEquals('?filter=lastUpdated$gte:2023-02-15', QueryGeneratorService::generateQuery($this->filters));
    }

    /** @test */
    public function will_correctly_add_filter_string_with_ampersand_if_connectorType_is_true()
    {
      $this->assertEquals('&filter=lastUpdated$gte:2023-02-15', QueryGeneratorService::generateQuery($this->filters, [], true));
    }

    /** @test */
    public function will_correctly_add_multiple_filter_strings()
    {
      $this->filters[] = ['city', '=', 'Skopje'];

      $this->filters[] = ['country', '=', 'Macedonia'];

      $this->assertEquals('?filter=lastUpdated$gte:2023-02-15$and:city$eq:Skopje$and:country$eq:Macedonia', QueryGeneratorService::generateQuery($this->filters)); 
    }

    /** @test */
    public function will_correctly_add_sort_string()
    {
      $this->assertEquals('?sort=-orderNumber', QueryGeneratorService::generateQuery([], $this->sorts)); 
    }

    /** @test */
    public function will_correctly_add_sort_string_with_ampersand_if_connectorType_is_true()
    {
      $this->assertEquals('&sort=-orderNumber', QueryGeneratorService::generateQuery([], $this->sorts, true)); 
    }

    /** @test */
    public function will_correctly_sort_multiple_sorting_predicates()
    {
      array_push($this->sorts, 'age');
      array_push($this->sorts, '-name');

      $this->assertEquals('?sort=-orderNumber,age,-name', QueryGeneratorService::generateQuery([], $this->sorts)); 
    }

    /** @test */
    public function will_correctly_attach_both_filter_and_sort_strings()
    {
      $this->assertEquals('?filter=lastUpdated$gte:2023-02-15&sort=-orderNumber', QueryGeneratorService::generateQuery($this->filters, $this->sorts)); 
    }

    /** @test */
    public function string_will_begin_with_an_ampersand_if_connectorType_is_true()
    {
      $this->assertEquals('&filter=lastUpdated$gte:2023-02-15&sort=-orderNumber', QueryGeneratorService::generateQuery($this->filters, $this->sorts, true)); 
    }

    /** @test */
    public function multiple_string_and_filter_predicates_will_get_built_together()
    {

      $this->filters[] = ['city', '=', 'Skopje'];
      $this->filters[] = ['country', '=', 'Macedonia'];


      array_push($this->sorts, 'age');
      array_push($this->sorts, '-name');

      $this->assertEquals('?filter=lastUpdated$gte:2023-02-15$and:city$eq:Skopje$and:country$eq:Macedonia&sort=-orderNumber,age,-name', QueryGeneratorService::generateQuery($this->filters, $this->sorts, false)); 
    }

    /** @test */
    public function if_empty_arrays_get_passed_nothing_will_get_returned()
    {
      $this->assertEquals('', QueryGeneratorService::generateQuery([], []));
    }
}