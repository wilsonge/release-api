### CMS Downloads Site API
This is comprised of two folder. The first is the libraries directory that must be installed
as usual through the extension manager.

The api folder must then be inserted at the top level of your site

### How does it work?
The libraries containers an open_api.json file. You can find further information on the Open API
standard on their [GitHub page](https://github.com/OAI/OpenAPI-Specification). This repository
is using version 2 of the standard. These then map to "New MVC" controllers.

There is a custom error handler and extra application type to manage how the application finds
controllers, manages routes and deals with non-html error handling.