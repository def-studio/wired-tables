<?php

use DefStudio\WiredTables\Elements\Column;
use DefStudio\WiredTables\Enums\Config;
use Illuminate\Database\Eloquent\Builder;

test('defaults', function () {
    $table = fakeTable();
    $table->id = 1234;
    $column = new Column($table, "Test");


    expect($column->toArray())->toBe([
        'is_sortable' => false,
        'name' => 'Test',
        'db_column' => 'test',
        'id' => 'e562ec174202bbd67b8ba02e26e57dc9',
        'field' => 'test',
        'is_relation' => false,
        'relation' => '',
    ]);
});

it('can set its current model', function(){
    $table = fakeTable();
    $column = new Column($table, "Name");

    $column->setModel(Car::make(['name' => 'foo']));

    expect($column->value())->toBe("foo");
});

it('can return its name', function(){
    $column = new Column(fakeTable(), "Foo");

    expect($column->name())->toBe("Foo");
});

it('can return its dbColumn', function(){
    $column = new Column(fakeTable(), "Foo", 'model.field');

    expect($column->dbColumn())->toBe("model.field");
});

it('can compute its dbColumn from the name', function(){
    $column = new Column(fakeTable(), "Foo Bar");

    expect($column->dbColumn())->toBe("foo_bar");
});

it('can return its id', function () {
    $table = fakeTable();
    $table->id = 1234;
    $column = new Column($table, "Test");


    expect($column->id())->toBe('e562ec174202bbd67b8ba02e26e57dc9');
});

it('can be set as sortable', function(){
    $column = new Column(fakeTable(), "Foo Bar");

    expect($column->get(Config::is_sortable))->toBeFalse();

    $column->sortable();

    expect($column->get(Config::is_sortable))->toBeTrue();
});

it('can be set as sortable through a closure', function(){
    $column = new Column(fakeTable(), "Foo Bar");

    $column->sortable(function(Builder $query){});

    expect($column->get(Config::sort_closure))->toBeCallable();
});

it('can check if it is sortable', function(){
    $column = new Column(fakeTable(), "Foo Bar");
    $column->sortable();

    expect($column->isSortable())->toBeTrue();
});

it('can format its value', function(){
    $column = new Column(fakeTable(), "Name");
    $column->format(function(Column $column){
        return strtoupper($column->value());
    });

    expect($column->get(Config::format_closure))->toBeCallable();
});

it('can return its value', function(){
    $column = new Column(fakeTable(), "Name");
    $column->format(function(Column $column){
        return strtoupper($column->value());
    });

    $column->setModel(Car::make(['name' => 'foo']));

    expect($column->value())->toBe('foo');
});

it('can return a relationship value', function(){
    $column = new Column(fakeTable(), "Owner", 'owner.name');

    $relationship = User::make(['name' => 'foo']);

    $model = Car::make(['name' => 'bar']);
    $model->setRelation('owner', $relationship);

    $column->setModel($model);

    expect($column->value())->toBe('foo');
});

it('can render a formatted value', function(){
    $column = new Column(fakeTable(), "Name");
    $column->format(function(Car $car){
        return strtoupper($car->name);
    });


    $column->setModel(Car::make(['name' => 'foo']));

    expect($column->render()->toHtml())->toBe('FOO');
});

it('can check if it is a relation column', function(){
    $column = new Column(fakeTable(), "Name");
    expect($column->isRelation())->toBeFalse();

    $column = new Column(fakeTable(), "Owner", 'owner.name');
    expect($column->isRelation())->toBeTrue();
});

it('can return its relation', function(){
    $column = new Column(fakeTable(), "Owner", 'owner.name');
    expect($column->getRelation())->toBe('owner');

    $column = new Column(fakeTable(), "Owner", 'owner.wife.name');
    expect($column->getRelation())->toBe('owner.wife');
});

it('can return its field', function(){
    $column = new Column(fakeTable(), "Name", 'name');
    expect($column->getField())->toBe('name');

    $column = new Column(fakeTable(), "Owner", 'owner.name');
    expect($column->getField())->toBe('name');

    $column = new Column(fakeTable(), "Owner", 'owner.wife.name');
    expect($column->getField())->toBe('name');
});