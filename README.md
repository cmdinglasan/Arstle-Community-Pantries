<p align="center"><a href="https://arstlemedia.com" target="_blank"><img src="https://arstlemedia.com/wp-content/uploads/2021/04/arstle_logo_blue_2019.png" width="200"></a></p>

## About the project

This is a Laravel-based API containing the list of community pantries in PH added on the database.

## Features

- **Community Pantry API**: Developers can capture the data of community pantries.

## API

| method | url           | description | example |
| ------ | ------------- | ----------- | ------- |
| GET    | /api/pantries | Return the list of community pantries | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries) |

## Parameters ##

| method | parameter     | description | example |
| ------ | ------------- | ----------- | ------- |
| GET    | ?region={region} | Return the list by region | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?region=National%20Capital%20Region) |
| GET    | ?city={city} | Return the list by city | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?city=Taguig) |
| GET    | ?sortBy={category} | Return the list by category (see category parameters below). Default alphabetical order is Ascending | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?sortBy=region) |
| GET    | ?order={order} | Return the list either 'asc' or 'desc' | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?order=desc) |
| GET    | ?coordsOnly={true | false} | Returns the names of the pantries and their map coordinates | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?coordsOnly=true) |

## Category Parameters

| Category | description | example |
| -------- | ----------- | ------- |
| region   | Return the list by 'region' | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?sortBy=region) |
| city   | Return the list by 'city' | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?sortBy=city) |
| ?order   | Return the list by category depending on order (asc or desc) | [Live Version](https://arstle-pantries.herokuapp.com/api/pantries?sortBy=city&order=desc) |

## How does it work?
<details>
    <summary>Few explanation on the API</summary><br/>
    - The API returns the result.
</details>

## Contribute
To contribute in adding in the list of community pantries, you may click here [Arstle Pantries](https://arstle-pantries.herokuapp.com/pantries)

## License
[MIT](https://opensource.org/licenses/MIT) - Copyright &copy; [Arstle Media](https://arstlemedia.com)

## Credits
[Christian Dinglasan](https://cmdinglasan.com)

## Contributors


