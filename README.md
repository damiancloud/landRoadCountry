# Land Route Finder with Symfony 6

This project involves creating a framework using Symfony 6 to calculate any possible land route from one country to another. The objective is to take a list of country data in JSON format and calculate the route by utilizing individual countries' border information.


## Specifications

- Data link: [countries.json](https://raw.githubusercontent.com/mledoze/countries/master/countries.json)
- The function returns a list of border crossings to get from the origin to the destination.
- A single route is returned if the journey is possible.
- The algorithm needs to be efficient.
- If there is no land crossing, the function returns the message 'Is not possible.'
- Countries are identified by the cca3 field in country data.
- Example land route from Czech Republic to Italy: `["CZE", "AUT", "ITA"]`
- Input arguments for the function: origin country (e.g., CZE), destination country (e.g., ITA)
- The function returns an array with a list of countries (e.g., `["CZE", "AUT", "ITA"]`)


**BFS Algorithm**: This solution leverages the Breadth-First Search (BFS) algorithm, a widely-used graph traversal algorithm, to efficiently explore and find the shortest path between countries. BFS ensures that the shortest path is discovered by exploring neighboring nodes before moving deeper into the graph.

## Getting Started

To start the project, follow these steps:

1. Run the following command to build the Docker container and install dependencies:

```bash
make start
```

2. Start the Docker container:

```bash
make up
```

## Access the container's console:

```bash
make console
```
To send a request to calculate a land route between Poland (POL) and Cyprus (CYP), open your browser and navigate to:

```
http://127.0.0.1:8000/routing/POL/CYP
```

## Testing

```bash
vendor/bin/phpunit
```