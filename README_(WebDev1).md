# SK Production Hub (Retake Project)

## Project overview
SK Production Hub is a web application focused on publishing and discovering DJ mixes from both upcoming and established artists.
The idea behind the project is to create a small music platform where visitors can browse public mixes, listen to them directly on the site, and interact with the content. 
Registered users can comment, vote, and submit their own mixes for review. 
Admin users can manage the content of the platform.

## Main features
- Homepage with featured mixes
- Mix overview page
- Mix detail page
- Embedded SoundCloud player on the detail page
- Login and registration system
- Comment system on mixes
- Like and dislike voting system
- Mix submission form for users
- Submission review page for admins
- Approve or reject submissions (admin only)
- Create mix feature (admin only)
- Delete mix feature (admin only)
- Custom 404 page
- Custom “mix not found” message

## Technologies used
- PHP
- MySQL
- PDO
- FastRoute
- Bootstrap 5
- JavaScript 
- Docker
- phpMyAdmin

## Project structure
the MVC architecture: 

- **Controllers** handle routes, page responses, and API responses
- **Services** contain validation and business logic
- **Repositories** handle database queries
- **Views** handle the frontend output
- **Models** represent application data

## Authentication and roles
The application supports multiple user states and roles:

- **Anonymous visitor**: can browse public content without logging in
- **Logged-in user**: can comment, vote, and submit mixes
- **Admin user**: can review submissions, create mixes, and delete mixes

## API and JavaScript
This project contains a JSON API for the voting system.


## Prepared statements
Database queries are handled with PDO prepared statements in the repository layer. This helps protect the application against SQL injection because values are not directly placed into raw SQL strings. This can be seen in the repository methods where `prepare()` and `execute()` are used.

## Password security
Passwords are not stored in plain text. During registration I use `password_hash()` to store a hashed password, and during login I use `password_verify()` to check it.

## Session-based authentication
The project uses PHP sessions for login state. Protected actions such as commenting, mix creation, submission review, and deletion are only available when the user is logged in and has the correct role.

## Validation
Validation is handled mainly in the service layer. For example, invalid mix input, empty comments, invalid vote types, and invalid registration data all trigger validation logic before any database action happens. I later refactored this to use `ValidationException` so that the controllers stay thinner and the service layer handles the business rules more clearly.

## Styling
Bootstrap is used as the CSS framework for layout, forms, buttons, cards, spacing, and responsiveness.
And the style for my Sk production page is black and orange (kind of similar to soundcloud color scheme), for i am more focused on dj mixes then single tracks.

## WCAG and accessibility

- Clear heading structure on pages such as the homepage and detail pages (WCAG 2.2 Success Criterion 2.4.6: Headings and Labels)
- Labels on forms so users can understand what each input is for (WCAG 2.2 Success Criterion 3.3.2: Labels or Instructions) 
- Visible buttons and links with readable text (WCAG 2.4.4: Link Purpose)
- Responsive layout using Bootstrap so the site also works on smaller screens 
- Strong contrast between background and text in most parts of the website (WCAG 2.2 Success Criterion 1.4.3: Contrast)


### Areas that support accessibility in the code
- Bootstrap grid and responsive classes are used throughout the layout
- Forms are built with visible labels and standard form controls
- Navigation uses clear text links
- Buttons are clearly named and grouped by purpose
- A custom 404 page is provided instead of a blank error screen


## GDPR and privacy

### Data that can be stored
- Email address
- Username
- Password hash
- Comments
- Votes
- Mix submissions
- Admin-created mix content

### Why this data is stored
- **Email and username** are needed for account creation and login
- **Password hash** is needed for secure authentication
- **Comments and votes** are needed for interaction features
- **Mix submissions** are needed for the submission and moderation flow
- **Session data** is used to keep users logged in while using the application


## Setup instructions
1. Start the Docker containers with:
   `docker-compose up`
2. Open the website at:
   `http://localhost`
3. Open phpMyAdmin at:
   `http://localhost:8080`

## Database
The SQL export of the database is included in the root of this project.

### SQL file name
`sk_production_hub.sql`

### Database name
`sk_production_hub`

## Test accounts
### Admin account
- Email: `admin@skhub.local`
- Password: `Password123!`

### Standard user account
- Email: `helpdesk@helpdesk.nl`
- Password: `helpdesk`

## Author
**Name:** JD Van Doorn  
**Email:** 728309@student.inholland.nl  
**Student number:** 728309

DESCLAIMER : I made an update on my GITHUB, This is the better version where the admin can approve and it will come on the webpage itself

**Repository link:** https://github.com/728309/web_development_1_boilerplate.git
