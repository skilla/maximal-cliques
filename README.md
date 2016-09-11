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

## Performance


1000 repetitions with the function "obtainCompleteGraphsWithoutPivoting". Using the same data as in the test.  
Vertex: 6  
Edges: 7  
Cliques: 5  
Time: 0.347 seconds  
Memory: 786432 bytes

1000 repetitions with the function "obtainCompleteGraphsWithPivoting". Using the same data as in the test.  
Vertex: 6  
Edges: 7  
Cliques: 5  
Time: 0.480 seconds  
Memory: 786432 bytes  

1000 repetitions with the function "obtainCompleteGraphsWithVertexOrdering". Using the same data as in the test.  
Vertex: 6  
Edges: 7  
Cliques: 5  
Time: 0.488 seconds  
Memory: 786432 bytes  

One repetitions with the function "obtainCompleteGraphsWithoutPivoting". Using 100 vertex.  
Vertex: 100  
Edges: 2507  
Cliques: 17215  
Time: 228.430 seconds  
Memory: 19398656 bytes  

One repetitions with the function "obtainCompleteGraphsWithPivoting". Using 100 vertex.  
Vertex: 100  
Edges: 2507  
Cliques: 17215  
Time: 199.249 seconds  
Memory: 19398656 bytes  

One repetitions with the function "obtainCompleteGraphsWithVertexOrdering". Using 100 vertex.  
Vertex: 100  
Edges: 2507  
Cliques: 17215  
Time: 157.969 seconds  
Memory: 19398656 bytes  
