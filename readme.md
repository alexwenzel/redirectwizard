# redirect Wizard

This plugin helps you to manage redirection of incoming requests.

Your can customize the request method and use a wildcard/optional parameter.

It redirects to any url with a given HTTP status code.

## Example

Your redirect: ``/foo/bar``

Request 1: ``/foo`` matches not  
Request 2: ``/foo/bar`` matches

## Wildcards

Your redirect: ``/foo/{wildcard}/bar``

Request 1: ``/foo`` matches not  
Request 2: ``/foo/foo`` matches not  
Request 3: ``/foo/foo/bar`` matches  
Request 3: ``/foo/123456789/bar`` matches  
Request 3: ``/foo/123456789/bar/foo`` matches not

Wildcard expression looks like `{wildcard}`

## Optional Parameters

Your redirect: ``/abc/{optional?}``

Request 1: ``/abc`` matches  
Request 2: ``/abc/foo`` matches  
Request 3: ``/abc/foo/bar`` matches not

## Caching

Redirects are cached forever. This means you have to empty the 
October cache when you like to become new redirects effective.
