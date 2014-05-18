# Create RESTful API responses with ease

This package enables you to create RESTful API responses without thinking about the specifics of the underlying HTTP layer. You provide data and the package will take care of **output format** and **status codes**. In case of an application error also RESTful error reponses can be created. The package is optimized for the use with the [Laravel](http://laravel.com/) framework. This documentation heavily focuses on the use within the Laravel framework.

## Basic Usage

*RESTful* provides two separate functions for returning a `collection` or a single `entity`.

 * **Entity**: If you follow the REST conventions an entity is a single entry of a REST resource. In most cases an entity is returned whenever the URI ends with a resource ID.
 * **Collection**: A collection contains a set of entities

### Returning a single entity

To return a single entity you can call the `entity` method on the `Restful` facade and provide anything that implements the `ArrayAccess` interface.

	$response = Restful::entity([
		'name' => 'Dexter',
		'age' => 1
	]);
	
*RESTful* will return a `\Illuminate\Http\Response` which directly extends the `\Symfony\Component\HttpFoundation\Response`. If you work with the Laravel 4 framework you can directly return the response object.

If you use the response object correctly the application will return:

	Content-Type:application/json

	{
		name: "Dexter",
		age: 1
	}

### Returning a collection

Analogous to the entity method the `collection` method accepts a collection of entities.

	$response = Restful::collection([
		[
			'name' => 'Dexter',
			'age' => 1
		],	
		[
			'name' => 'Dori',
			'age' => 1
		],	
	]);
	
The collection may be of the type:

 - `array`: Use an indexed array (as a collection) containing associative arrays (as entities)
 - `Illuminate\Support\Collection`: Basically the same as providing an array.
 - `\Illuminate\Pagination\Paginator`: When a paginator is provided *RESTful* will automatically include metadata about the pagination in the response.
 
The response will look like:

	Content-Type:application/json
	
	{
		data: [
			{
				name: "Dexter",
				age: 1
			},
			{
				name: "Dori",
				age: 1
			}
		]
	}
	
Be aware that collections are wrapped into a `data` attribute. This is necessary because collections may also return `metadata`. This metadata may include pagination information.
 
## Usage in Laravel 4

When using *RESTful* in *Laravel 4* you can leverage the power of *Eloquent* to drive your responses. Consider the following lines as result of any controller action.

	return Restful::entity(Dogs::find(1));
    return Restful::collection(Dogs::all());
    return Restful::collection(Dogs::paginate(3));

## Advanced API

### Forcing output format

If you wan't to force an output format you can use the corresponding method and chain it with the output you want to serve.

    return Restful::serialized()->collection(Dogs::all());
    return Restful::php()->collection(Dogs::all());
    return Restful::json()->collection(Dogs::all());
    return Restful::jsonp('myFunction')->collection(Dogs::all());
    return Restful::yaml()->collection(Dogs::all());
    return Restful::xml()->collection(Dogs::all());
    
*Content-Type* header will be set automatically according to the specified format.

## Errors

Also common errors can easily be handled with *RESTful*.

    return Restful::code(404)->error("Ups");
    return Restful::forbidden();
    return Restful::unauthorized();
    return Restful::missing();
    
# Installation

## Within Laravel 4 framework

To install *RESTful* simply add it as a requirement to the projects `composer.json`:

	"require": {
		"lukaskorl/restful": "dev-develop"
	}
	
or run `composer require lukaskorl/restful`.
	
**Word of caution**: *RESTful* is currently under heavy development. I will release a stable version 1.0.0 soon. Until then the interface may change. I do not recommend to use *RESTful* as a `dev-develop` dependency in production code.


## License

*RESTful* is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)
