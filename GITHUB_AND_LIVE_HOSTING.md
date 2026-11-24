# FireGuard: GitHub source + public website deployment

## Important distinction
GitHub stores your source code. GitHub Pages cannot execute PHP or run this project's MySQL database. To let your lecturer open the working site without installing Laragon/XAMPP, publish the PHP application on a PHP/MySQL web host and share that public website URL. Keep the GitHub repository as the source-code link.

## GitHub repository
1. Create a new repository, for example `fireguard-fire-emergency-system`.
2. Extract this project ZIP. Upload the **contents of the `fire-emergency-system` folder** to the repository root (so `index.php`, `register.php`, `config/`, `assets/`, etc. are at the top level).
3. Keep the repository free of database passwords. The `.gitignore` file excludes `config/database.local.php`.
4. Commit and push the project files.

## Free PHP/MySQL hosting example: InfinityFree
The steps below are for a free academic demonstration deployment. Hosting providers can change their limits and availability; check their current terms before relying on the site for an assessment.

1. Create a PHP/MySQL hosting account and choose a free subdomain.
2. Open the hosting control panel and create a MySQL database. Copy its exact database host, database name, username, and password. Do not use `localhost` unless the provider explicitly says to.
3. Open the provider's phpMyAdmin, select the newly created database, and import `database-hosting.sql` (not `database.sql`). This hosting version omits `CREATE DATABASE` and `USE`, because the host has already created the database for your account.
4. Upload the application files to the hosting account's web root, commonly named `htdocs`. Upload the contents of this project folder, not the outer folder itself. Use the host's File Manager or FTP.
5. In the hosted `config/` folder, copy `database.local.php.example` to `database.local.php`. Edit the new file and replace all four placeholders with your host's exact MySQL credentials. Do not upload this private file to GitHub.
6. Open the public subdomain over HTTPS and test registration, login, report submission, My Reports, administrator login, status updates, and status tracking.
7. Create a normal account. In the host's phpMyAdmin, run the following query after replacing the email address with your own account's email:

   ```sql
   UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
   ```

8. Log out and log back in, then verify the Admin Dashboard and report review page.

## What to share with your lecturer
- **Live website URL:** the public HTTPS subdomain from your hosting provider. This is what your lecturer clicks to use the website in a browser.
- **GitHub repository URL:** the repository containing your source code.

The lecturer does not need Laragon, XAMPP, PHP, or MySQL installed to visit the live URL. They only need an internet connection and a browser. The hosting account must remain active and the database must remain available.

## Security and academic-demo notes
- Never commit database passwords or private configuration files.
- Use HTTPS and a strong, unique hosting/database password.
- Use fictional test data only; do not collect real emergency or personal information.
- This is an academic incident-reporting demonstration. It does not contact 112, fire stations, or emergency responders. In a real emergency, move to safety and contact emergency services directly.
- Back up the database and source files. Free hosting may have availability, resource, and account-activity limits.
