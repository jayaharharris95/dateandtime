# dateandtime
Story: As a user, I should be able to see the Site location and the current time for the location.

Implementation details:
Add an ADMIN CONFIGURATION form which will take the following inputs:
Country - text field
City - text field
Timezone - select list
Create a service that will return the current time based on the time zone selection in the above form. Time should be in the format 25th Oct 2019 - 10:30 PM
Add a Plugin block which will render the Location from the configuration set in the ACF and the current time calling the service in the previous step. Pass the variables to a template to be rendered.
