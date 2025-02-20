<?php

use function Pest\Livewire\livewire;

it('properly displays "openModal" on edit button', function (string $component, object $params) {
    livewire($component, ['join' => $params->join])
        ->call($params->theme)
        ->set('setUp.footer.perPage', 6)
        ->assertSeeHtml('$emit("openModal", "edit-stock", {"dishId":1})')
        ->assertSeeHtml('$emit("openModal", "edit-stock", {"dishId":2})')
        ->assertDontSeeHtml('$emit("openModal", "edit-stock", {"dishId":7})')
        ->call('setPage', 2)
        ->assertDontSeeHtml('$emit("openModal", "edit-stock", {"dishId":6})')
        ->assertDontSeeHtml('$emit("openModal", "edit-stock", {"dishId":1})');
})->with('action');

it('properly displays "deletedEvent" on delete button', function (string $component, object $params) {
    livewire($component, ['join' => $params->join])
        ->call($params->theme)
        //page 1
        ->set('setUp.footer.perPage', 5)
        ->assertSeeHtml('$emit("deletedEvent", {"dishId":1})')
        ->assertDontSeeHtml('$emit("deletedEvent", {"dishId":6})')
        ->assertPayloadNotSet('eventId', ['dishId' => 1])
        ->call('deletedEvent', ['dishId' => 1])
        ->assertPayloadSet('eventId', ['dishId' => 1])

        //page 2
        ->call('setPage', 2)
        ->assertSeeHtml('$emit("deletedEvent", {"dishId":6})')
        ->assertDontSeeHtml('$emit("deletedEvent", {"dishId":1})')
        ->assertPayloadNotSet('deletedEvent', ['dishId' => 6])
        ->call('deletedEvent', ['dishId' => 6])
        ->assertPayloadSet('eventId', ['dishId' => 6]);
})->with('action');

it('properly displays "deletedEvent" on delete button from emitTo', function (string $component, object $params) {
    livewire($component, ['join' => $params->join])
        ->call($params->theme)
        //page 1
        ->set('setUp.footer.perPage', 5)
        ->assertSeeHtml('$emitTo("dishes-table", "deletedEvent", {"dishId":1})')
        ->assertDontSeeHtml('$emitTo("dishes-table", "deletedEvent", {"dishId":6})')
        ->assertPayloadNotSet('eventId', ['dishId' => 1])
        ->call('deletedEvent', ['dishId' => 1])
        ->assertPayloadSet('eventId', ['dishId' => 1])

        //page 2
        ->call('setPage', 2)
        ->assertSeeHtml('$emitTo("dishes-table", "deletedEvent", {"dishId":6})')
        ->assertDontSeeHtml('$emitTo("dishes-table", "deletedEvent", {"dishId":1})')
        ->assertPayloadNotSet('deletedEvent', ['dishId' => 6])
        ->call('deletedEvent', ['dishId' => 6])
        ->assertPayloadSet('eventId', ['dishId' => 6]);
})->with('action');

it('properly displays "bladeComponent" on bladeComponent button', function (string $component, object $params) {
    livewire($component, ['join' => $params->join])
        ->call($params->theme)
        ->set('setUp.footer.perPage', 6)
        ->assertSeeHtml('<svg dish-id="1"')
        ->assertSeeHtml('<svg dish-id="2"')
        ->assertSeeHtml('<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />')
        ->assertDontSeeHtml('<svg dish-id="7"')
        ->call('setPage', 2)
        ->assertDontSeeHtml('<svg dish-id="6"')
        ->assertDontSeeHtml('<svg dish-id="1"');
})->with('action');
