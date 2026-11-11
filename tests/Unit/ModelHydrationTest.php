<?php

namespace Tests\Unit;

use LasseRafn\Economic\Models\Unit;
use LasseRafn\Economic\Utils\Request;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ModelHydrationTest extends TestCase
{
    #[Test]
    public function it_hydrates_declared_and_undeclared_api_fields_without_deprecations()
    {
        $unit = new Unit(new Request('token', 'secret', false, 'https://example.test'), (object) [
            'unitNumber'      => 1,
            'name'            => 'Pcs',
            'someNewApiField' => 'value',
        ]);

        $this->assertSame(1, $unit->unitNumber);
        $this->assertSame('Pcs', $unit->name);
        $this->assertSame('value', $unit->someNewApiField);
        $this->assertSame('value', $unit->toArray()['someNewApiField']);
    }
}
