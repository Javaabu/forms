<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class Country extends Model
{
    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => 'Formatted ' . $this->name,
        );
    }

    public function getListNameAttribute()
    {
        return 'List ' . $this->name;
    }
}

class State extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

class City extends Model
{
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}

class Address extends Model
{
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getFormattedNameAttribute()
    {
        return 'Formatted ' . $this->name;
    }

    public function getStateAttribute()
    {
        return $this->city?->state;
    }

    public function getCountryAttribute()
    {
        return $this->state?->country;
    }
}

class Select2CascadeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_select2_options_from_a_collection()
    {
        $countryA = Country::create(['name' => 'Maldives']);
        $countryB = Country::create(['name' => 'India']);
        $countryC = Country::create(['name' => 'Japan']);

        $stateA = State::create(['name' => 'State A', 'country_id' => $countryB->id]);

        $cityA = City::create(['name' => 'City A', 'state_id' => $stateA->id]);

        $address = Address::create(['name' => 'Acme Road', 'city_id' => $cityA->id]);

        Route::get('select2-collection', function () use ($address) {
            return view('select2-collection')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/select2-collection')
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]:not(:selected)')
            ->seeElement('option[value="' . $countryA->getKey() . '"]:not(:selected)')
            ->seeElement('option[value="' . $countryB->getKey() . '"]:selected')
            ->seeElement('option[value="' . $countryC->getKey() . '"]:not(:selected)');
    }

    #[Test]
    public function it_can_create_select2_options_from_a_query_builder()
    {
        $countryA = Country::create(['name' => 'Maldives']);
        $countryB = Country::create(['name' => 'India']);
        $countryC = Country::create(['name' => 'Japan']);

        $stateA = State::create(['name' => 'State A', 'country_id' => $countryB->id]);

        $cityA = City::create(['name' => 'City A', 'state_id' => $stateA->id]);

        $address = Address::create(['name' => 'Acme Road', 'city_id' => $cityA->id]);

        Route::get('select2-query', function () use ($address) {
            return view('select2-query')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/select2-query')
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]:not(:selected)')
            ->seeElement('option[value="' . $countryA->getKey() . '"]:not(:selected)')
            ->seeElement('option[value="' . $countryB->getKey() . '"]:selected')
            ->seeElement('option[value="' . $countryC->getKey() . '"]:not(:selected)');
    }

    #[Test]
    public function it_can_extract_an_accessor_field_from_the_builder()
    {


        $countryA = Country::create(['name' => 'Maldives']);
        $countryB = Country::create(['name' => 'India']);
        $countryC = Country::create(['name' => 'Japan']);

        $stateA = State::create(['name' => 'State A', 'country_id' => $countryB->id]);

        $cityA = City::create(['name' => 'City A', 'state_id' => $stateA->id]);

        $address = Address::create(['name' => 'Acme Road', 'city_id' => $cityA->id]);

        Route::get('select2-query-accessor', function () use ($address) {
            return view('select2-query-accessor')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/select2-query-accessor')
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"][data-name-field="formatted_name"]')
            ->seeElement('option[value=""]:not(:selected)')
            ->seeElement('option[value="' . $countryA->getKey() . '"]:not(:selected)')
            ->seeInElement('option[value="' . $countryA->getKey() . '"]:not(:selected)', 'Formatted Maldives')
            ->seeElement('option[value="' . $countryB->getKey() . '"]:selected')
            ->seeInElement('option[value="' . $countryB->getKey() . '"]:selected', 'Formatted India')
            ->seeElement('option[value="' . $countryC->getKey() . '"]:not(:selected)');
    }

    #[Test]
    public function it_can_extract_a_get_accessor_field_from_the_builder()
    {


        $countryA = Country::create(['name' => 'Maldives']);
        $countryB = Country::create(['name' => 'India']);
        $countryC = Country::create(['name' => 'Japan']);

        $stateA = State::create(['name' => 'State A', 'country_id' => $countryB->id]);

        $cityA = City::create(['name' => 'City A', 'state_id' => $stateA->id]);

        $address = Address::create(['name' => 'Acme Road', 'city_id' => $cityA->id]);

        Route::get('select2-query-get-accessor', function () use ($address) {
            return view('select2-query-get-accessor')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/select2-query-get-accessor')
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"][data-name-field="list_name"]')
            ->seeElement('option[value=""]:not(:selected)')
            ->seeElement('option[value="' . $countryA->getKey() . '"]:not(:selected)')
            ->seeInElement('option[value="' . $countryA->getKey() . '"]:not(:selected)', 'List Maldives')
            ->seeElement('option[value="' . $countryB->getKey() . '"]:selected')
            ->seeInElement('option[value="' . $countryB->getKey() . '"]:selected', 'List India')
            ->seeElement('option[value="' . $countryC->getKey() . '"]:not(:selected)');
    }

    #[Test]
    public function it_can_render_a_select2_cascade()
    {


        $countryA = Country::create(['name' => 'Maldives']);
        $countryB = Country::create(['name' => 'India']);
        $countryC = Country::create(['name' => 'Japan']);

        $stateA = State::create(['name' => 'State A', 'country_id' => $countryA->id]);
        $stateB = State::create(['name' => 'State B', 'country_id' => $countryA->id]);
        $stateC = State::create(['name' => 'State C', 'country_id' => $countryA->id]);

        $city1 = City::create(['name' => 'City 1', 'state_id' => $stateA->id]);
        $city2 = City::create(['name' => 'City 2', 'state_id' => $stateA->id]);
        $city3 = City::create(['name' => 'City 3', 'state_id' => $stateA->id]);

        $cityA = City::create(['name' => 'City A', 'state_id' => $stateB->id]);
        $cityB = City::create(['name' => 'City B', 'state_id' => $stateB->id]);
        $cityC = City::create(['name' => 'City C', 'state_id' => $stateB->id]);

        $address = Address::create(['name' => 'Acme Road', 'city_id' => $cityC->id]);

        Route::get('select2-cascade', function () use ($address) {
            return view('select2-cascade')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/select2-cascade')
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"][name="country"][id="country"]')
            ->within('select[name="country"][id="country"]', function () use ($countryA, $countryB, $countryC) {
                $this->seeElement('option[value=""]:not(:selected)')
                    ->seeElement('option[value="' . $countryA->getKey() . '"]:selected')
                    ->seeElement('option[value="' . $countryB->getKey() . '"]:not(:selected)')
                    ->seeElement('option[value="' . $countryC->getKey() . '"]:not(:selected)');
            })
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"][name="state"][id="state"]')
            ->within('select[name="state"][id="state"]', function () use ($stateA, $stateB, $stateC) {
                $this->seeElement('option[value=""]:not(:selected)')
                    ->seeElement('option[value="' . $stateA->getKey() . '"]:not(:selected)')
                    ->seeElement('option[value="' . $stateB->getKey() . '"]:selected')
                    ->seeElement('option[value="' . $stateC->getKey() . '"]:not(:selected)');
            })
            ->seeElement('select.select2-basic[data-allow-clear="true"][data-placeholder="Nothing Selected"][name="city"][id="city"]')
            ->within('select[name="city"][id="city"]', function () use ($cityA, $cityB, $cityC, $city1, $city2, $city3) {
                $this->seeElement('option[value=""]:not(:selected)')
                    ->seeElement('option[value="' . $cityA->getKey() . '"]:not(:selected)')
                    ->seeElement('option[value="' . $cityB->getKey() . '"]:not(:selected)')
                    ->seeElement('option[value="' . $cityC->getKey() . '"]:selected')
                    ->dontSeeElement('option[value="' . $city1->getKey() . '"]')
                    ->dontSeeElement('option[value="' . $city2->getKey() . '"]')
                    ->dontSeeElement('option[value="' . $city3->getKey() . '"]');
            });
    }
}
