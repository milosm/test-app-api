# Test App API

This is a very simple test app API written with Slim http://www.slimframework.com

Usage is indented only for testing.

## It implements these endpoints:

URL | Method | Params | Description
------------ | ------------- | ------------
/ | GET | | Get the entire list
/list | GET | | Get the entire list
/list/:id | GET | id | Get id item
/list/add | POST | name, email, role | Add a new item
/list/:id | PUT | id | Edit id item
/list/:id | DELETE | id | Delete id item