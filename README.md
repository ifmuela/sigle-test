# Simple CRUD
Implementation of tokens and access level with `Santum`
Boards:
* User
* Project
* Task

## Access levels

User routes are free. The routes of both projects and tasks require a Santum token

## Project structure

As a description we have a focus on services. Models with their migrations, protected and released routes to access the controllers and the controllers request the services. This structure allows services to be reused, making the system more flexible and robust.

`IMPORTAN` We have an `HTTP-Client folder` with a .json that can import a collection to an HTTP-Client manager like Postman so that the functionalities can be tested

## Technology
I found it interesting to try `Laravel 11` and see the new settings to try and the Docker system that Sail provides.
We chose Santum for the access level instead of Passport
Maatwebsite for Excel functionalities

## Recommendations

The use of `Resources`
`Testing`
`Rule request`
and finally the visual part (recommending `Vue` or interesting to see the new integration of `Laravel 11` with `Next.js`)

## News 

For this level of application we detect only again in this `Laravel 11` the configuration required for the classic Routes
Also, since it executes the general `middleware` in the `bootstrap/app.php`, it no longer uses the interesting Kernel, very similar to lumen. For this level of testing we do not find anything newer


