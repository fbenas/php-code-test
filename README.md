# Phase 2 refactor

## Client
I've defined a client interface to allow us to make requests. In this case we'll be using an http client. One can imagine other implementations that do not use  http to make this request, we could use ssh, or a local file storage etc.
The concrete HTTP client forces us to define and use a handler and a paraser for requests. This is where the heavy lifting of the request will be done.

I've added a function get() to the http client that will simply run with GET as the method. With more time I could add the other HTTP methods such as PUT, DELETE, POST etc. This would allow us to do other request types and not just receive data, but create, read, update and delete.

### HTTP Handler
In a real world situation, I would choose to use an open and well maintained package for making http requests.
Example: https://github.com/guzzle/guzzle

In this case, it's not too much use showing off code that I've not written! So here I build our own http client.
There's a PSR standard for HTTP messaging (PSR-7) so we shall start by at least pulling in Guzzle's implementation of
the PSR-7 response, and request (to save time). https://github.com/guzzle/psr7

The original code was using CURL to make these requests. I've not really changed that implementation, or at least only to allow better injection of configuration.
One can imagine in the future we may want to make or use a different implementation that may not use CURL, for this we could crate a new Handler that implements our handler interface.

Within the curl handler, there's many more changes that I could make to make the code more useful, robust and testable. I've not gone any further here.

### Response Parser
I've added a parser interface to allow us to define multiple concretes to deal with different responses, and parse results. In this case I've kept the JSON/XML parsing to a minimum, we could go a lot further here to make a robust parser that handles exceptions and errors better.

## Model
I've decided to add a simple model interface and abstract model to allow us to store, and manipulate data. We can then build queries from our models, and have them be populated from http requests.

I've added a Book model as the example of a concrete model.

## Query
I've kept this quite simple to allow us to make simple queries. With more time I would like to build out the model/query relationship to allow us to build more complex and abstracted queries from our model based on fields available.
