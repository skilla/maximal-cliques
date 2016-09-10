# MaximalCliques
__PHP Library to resolve Maximal Cliques in undirected graph__

A clique of a graph G is a complete subgraph of G.
A maximal clique is a clique that cannot be extended by including one more adjacent vertex, meaning it is not a subset
of a larger clique


This implementation of Bron–Kerbosch's algorithm include three methods:

- Basic resolution (obtainCompleteGraphsWithoutPivoting)
- Pivoting resolution (obtainCompleteGraphsWithPivoting)
- Vertex ordering resolution (obtainCompleteGraphsWithVertexOrdering)


The three implementations return a array of maximal cliques each represented in an array of vertex.

For a graph G whit 6 nodes:
```
6 - 4 - 5 - 1
    |   |  /
    |   | /
    |   |/
    3 - 2
```
This will be composed of five maximal cliques:
```
[
    [1,2,5],
    [2,3],
    [3,4],
    [4,5],
    [4,6]
]
```

## Installation

composer require "skilla/MaximalCliques"

## How to use
The source code includes "DataTransformerExample" class that implements the "DataTransformerInterface" interface. The purpose of this is to serve as a test and example.  
Copy this class and adapt their methods to be able to process the data as generated in your application.  
Then follow any of the examples used to test the class in "test / BronKerboschAlgorithmsTest.php"