# My Book List - BookSelf

Do not open PHP with Live Server or by double-clicking files. Keep your old project/database as a backup: this version uses a different database structure.

## Administrator setup
Register through signup.php. Then select basic_books in phpMyAdmin and run:

```sql
UPDATE users SET role = 'admin' WHERE email = 'YOUR-REGISTERED-EMAIL';
```

Use the email you just registered, then log out and log in again. No default administrator password is supplied. Public signup always creates ordinary users. Do not add an admin role selector to that form.

## Files and purpose
| File | Purpose |
| --- | --- |
| connection.php | Shared PDO connection to MySQL |
| functions.php | Sessions, safe HTML output, tokens, URL and book validation |
| header.php | Bootstrap CDN, navigation and success messages |
| footer.php | Shared footer and closing HTML |
| errors.php | Shared validation messages |
| signup.php | Validate and create an ordinary account with a password hash |
| login.php | Verify the password and remember the account in a session |
| logout.php | Check POST/token and end the session |
| auth.php | Recheck the current admin role in MySQL |
| index.php | SELECT all books and display Bootstrap cards |
| details.php | Validate a URL ID and SELECT one book |
| admin.php | Management table with add/edit/delete links |
| book_form.php | Form shared by add and edit |
| add.php | Validate submitted values and INSERT a book |
| edit.php | Prefill the form, validate and UPDATE one book |
| delete.php | Confirm, then DELETE one book on POST |
| about.php | Project description and reference links |
| database.sql | Table creation and sample records |

## How the application works
A GET request displays a page. A form POST submits named fields to PHP. PHP checks the session token, reads fields, validates them and executes a prepared statement. Errors appear above the form; success stores a message in the session and redirects. Processing happens before header.php so redirects and session headers can be sent before HTML.

index.php uses SELECT, execute(), fetchAll() and foreach to display book cards. details.php uses the ID in its URL to retrieve one row. Invalid or missing records return 404.

## Database operations
- SELECT reads records.
- INSERT creates a record.
- UPDATE changes a record selected by WHERE id.
- DELETE removes a record selected by WHERE id.

Question marks are placeholders. execute() supplies values separately. Never remove WHERE from update/delete queries.

The users table contains ID, name, unique email, password hash and role. The books table contains ID, title, author, description, image URL and website URL. Both IDs are auto-increment primary keys. No relationship is needed because administrators manage a shared catalogue.

## Authentication and safety
password_hash() hashes the password on signup; password_verify() checks it at login. Sessions remember the authenticated user ID. Login regenerates the session ID. auth.php checks the current database role on every admin page. Hiding a link alone does not protect a page.

Prepared statements keep SQL values separate from query text. e() uses htmlspecialchars() to escape output for HTML. Form tokens reject forged submissions without the session token. Logout destroys the session and clears its cookie. The login cooldown is per browser session, a basic teaching measure rather than complete account/IP throttling. There is no password reset or email verification flow.

Server lengths use bytes; non-ASCII characters can use multiple bytes. Browser validation helps the user, but the PHP checks still enforce the rules if browser checks are bypassed.

## Pictures and website links
Paste a direct HTTPS image URL into the optional cover field. A webpage address usually cannot be used as an image address. Use an image you have permission to display. External image hosts can block embedding or remove their images. Existing sample books intentionally have no cover until you edit them.

The optional website link is separate from the image URL and the internal Details link. PHP accepts complete HTTP/HTTPS URLs only. The server does not download the remote image; the browser displays it.

## InfinityFree deployment
Use the hosting control panel to create your site and MySQL database. Import database.sql into the empty hosted database and copy its actual connection details into connection.php. Upload PHP files to the document root, use HTTPS and test all pages. Keep README.md, database.sql and the ZIP outside the public document root. Never publish real database credentials in a public repository.

Register a live account and promote it through the hosted phpMyAdmin. Local accounts are not transferred automatically. The hosting database name will normally differ from basic_books; use the name supplied by the host.

# BookSelf-PHP
