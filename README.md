# MaximalCliques
__PHP Library to resolve Maximal Cliques in undirected graph__

A clique of a graph G is a complete subgraph of G.
A maximal clique is a clique that cannot be extended by including one more adjacent vertex, meaning it is not a subset
of a larger clique


This implementation of Bron–Kerbosch's algorithm include three methods:

- Basic resolution (obtainCompleteGraphsWithoutPivoting)
- Pivoting resolution (obtainCompleteGraphsWithPivoting)
- Vertex ordering resolution (obtainCompleteGraphsWithVertexOrdering)

And three methods based on "obtainCompleteGraphsWithVertexOrdering" for advancing search and less time of resolution:
- Only cliques that include a specific vertex (obtainCompleteGraphsWithVertexOrderingForVertex)
- Only cliques whose degree is equal to or greater than the specified (obtainCompleteGraphsWithVertexOrderingWithMinimumDegree)
- Only cliques that include a specific vertex and whose degree is equal to or greater than the specified (obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree)

Finally, a function is included to collect the clique larger than those generated with one of the previous six functions.
- (retrieveMaximalClique)

The six implementations return a array of maximal cliques each represented in an array of vertex, "retrieveMaximalClique" returns a array of vertex.

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

for php 5.3 or lower use:  
composer require "skilla/maximal-cliques:0.1.*"  

for php 5.4 or higher  
composer require "skilla/maximal-cliques:dev-master"  


## How to use
The source code includes "DataTransformerExample" class that implements the "DataTransformerInterface" interface. The purpose of this is to serve as a test and example.  
Copy this class and adapt their methods to be able to process the data as generated in your application.  
Then follow any of the examples used to test the class in "test / BronKerboschAlgorithmsTest.php"

## Performance


Test 1 - 1,000 repetitions with the function "obtainCompleteGraphsWithoutPivoting". Using the same data as in the test.  
Vertex: 6  
Edges: 7  
Cliques: 5  
Time: 0.347 seconds  
Memory: 786,432 bytes

Test 2 - 1,000 repetitions with the function "obtainCompleteGraphsWithPivoting". Using the same data as in the test.  
Vertex: 6  
Edges: 7  
Cliques: 5  
Time: 0.480 seconds  
Memory: 786,432 bytes  

Test 3 - 1,000 repetitions with the function "obtainCompleteGraphsWithVertexOrdering". Using the same data as in the test.  
Vertex: 6  
Edges: 7  
Cliques: 5  
Time: 0.488 seconds  
Memory: 786,432 bytes  

Test 4 - One repetition with the function "obtainCompleteGraphsWithoutPivoting". Using 100 vertex.  
Vertex: 100  
Edges: 2,507  
Cliques: 17,215  
Time: 228.430 seconds  
Memory: 19,398,656 bytes  

Test 5 - One repetition with the function "obtainCompleteGraphsWithPivoting". Using 100 vertex.  
Vertex: 100  
Edges: 2,507  
Cliques: 17,215  
Time: 199.249 seconds  
Memory: 19,398,656 bytes  

Test 6 - One repetition with the function "obtainCompleteGraphsWithVertexOrderingForVertex". Using 100 vertex.  
Vertex: 100  
Edges: 2,507  
Cliques: 17,215  
Time: 157.969 seconds  
Memory: 19,398,656 bytes  

Test 7 - One repetition with the function "obtainCompleteGraphsWithVertexOrderingForVertex". Using 100 vertex.  
Selected vertex: 23  
Vertex: 100  
Edges: 2,507  
Cliques: 768  
Time: 2.219 seconds  
Memory: 4,718,592 bytes  

Test 8 - One repetition with the function "obtainCompleteGraphsWithVertexOrderingWithMinimumDegree". Using 100 vertex.  
Selected degree: 5  
Vertex: 100  
Edges: 2,507  
Cliques: 13,654  
Time: 156.963 seconds  
Memory: 16,252,928 bytes  

Test 9 - One repetition with the function "obtainCompleteGraphsWithVertexOrderingForVertexWithMinimumDegree". Using 100 vertex.  
Selected vertex: 23  
Selected degree: 5  
Vertex: 100  
Edges: 2,507  
Cliques: 588  
Time: 2.240 seconds  
Memory: 4,456,448 bytes  
