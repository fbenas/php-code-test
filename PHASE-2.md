# Phase 2 refactor
Now the code is ready to be refactored properly, we need to make some choices

Usually we'd have more domain knowledge and understanding of what the application will need to do. In this case, I'll add some constraints myself.

## Constraints
- Currently, our API client only deals with books. However our real-world book shop also sells other things! We'll need to be able to pull information from them.
- The current code does not handle exceptions and errors well. We should be able to handle a range of use cases where one or more steps fail.
- We want to improve our client, and add features to also update, and remove existing books and other products.

## Things we won't do now but we should at some point
- Authentication
- ???

- [ ]
