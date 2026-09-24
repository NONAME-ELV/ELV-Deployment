# HxN//ELV File Upload & `.htaccess` Manager

A minimal PHP web interface for uploading a file into the current working directory and creating/editing the local `.htaccess` file.

> **Important:** This README describes the behavior implemented by the supplied PHP source. The source itself does not contain authentication, authorization, filename validation beyond `basename()`, upload type restrictions, CSRF protection, or other access controls. Do not expose it to an untrusted or public environment without adding appropriate security controls.

## Features

- Uploads a selected file through a `multipart/form-data` POST request.
- Saves the uploaded file in the current working directory.
- Uses `basename()` on the submitted filename before constructing the destination path.
- Displays an `[OK] UPLOADED` status after a successful `move_uploaded_file()` operation.
- Provides a web form for entering or editing `.htaccess` content.
- Saves the submitted `.htaccess` content in the current working directory.
- Reads an existing `.htaccess` file and places its contents in the editor.
- Provides a default PHP `AddType` directive when `.htaccess` does not exist.
- Includes a cyan/magenta cyberpunk-style interface.
- Includes animated `HxN` / `ELV` ASCII-art switching and glitch-like text effects.

## Requirements

- A web server capable of running PHP.
- PHP support for:
  - `$_SERVER`
  - `$_FILES`
  - `move_uploaded_file()`
  - `file_put_contents()`
  - `file_exists()`
  - `file_get_contents()`
  - `getcwd()`
  - `basename()`
  - `htmlentities()`

The PHP process must have appropriate filesystem permissions for the directory in which the script runs.

## How It Works

### File upload

The application checks whether the request is a `POST` request and whether the `f` upload field exists.

The destination is constructed from the current working directory and the uploaded filename:

```php
$t = getcwd() . '/' . basename($_FILES["f"]["name"]);
```

The uploaded temporary file is then moved into that destination:

```php
move_uploaded_file($_FILES["f"]["tmp_name"], $t)
```

A successful upload produces:

```text
[OK] UPLOADED
```

### `.htaccess` editor

When the `htc` POST field is submitted, the application writes it to:

```text
.htaccess
```

The script reports either:

```text
[OK] .HTACCESS SAVED
```

or:

```text
[FAIL] CANNOT WRITE .HTACCESS
```

If an existing `.htaccess` file is present, its contents are loaded into the textarea and HTML-escaped with `htmlentities()` before being displayed.

If no `.htaccess` exists, the default editor content is:

```apache
AddType application/x-httpd-php .php .phtml .php3 .php4 .php5 .php7 .php8
```

## Interface

The supplied source uses:

- Dark background: `#05010a`
- Cyan accent: `#00f3ff`
- Magenta accent: `#bd00ff`
- `Courier New` / monospace typography
- Neon-style text shadows
- Dashed upload/editor container
- Hover effect on the buttons
- Animated `HxN` and `ELV` ASCII art

The ASCII logo alternates between `HxN` and `ELV` every 1.8 seconds. A second interval changes the text-shadow and skew approximately every 150 milliseconds to create a glitch effect.

## Forms

### Upload form

The upload form uses:

```html
<form method="POST" enctype="multipart/form-data">
```

and sends the file using the field:

```text
f
```

### `.htaccess` form

The editor uses:

```html
<form method="POST">
```

and sends the textarea using:

```text
htc
```

## Security Considerations

The supplied implementation is intentionally minimal, but several security controls are absent.

### 1. No authentication

The source does not require a username, password, session, or other authentication before allowing uploads or `.htaccess` changes.

Anyone who can reach the interface may therefore be able to use these functions, depending on the server configuration.

### 2. No upload allowlist

The code does not restrict uploaded extensions or MIME types.

An uploaded file can therefore have a server-executable extension if the server is configured to execute it.

### 3. Uploaded files are stored in the current directory

The destination is based on:

```php
getcwd()
```

and the supplied filename.

This means uploaded files are intentionally placed alongside the application rather than in a dedicated non-executable upload directory.

### 4. `.htaccess` can be modified

The application accepts arbitrary textarea content and writes it to `.htaccess`.

This can change Apache behavior for the directory and its descendants, depending on the server configuration.

### 5. No CSRF protection

The forms do not include a CSRF token.

If this interface is deployed in an authenticated application, CSRF protection should be added.

### 6. No upload-size or resource controls in the application

The source does not implement its own file-size, count, or resource limits. Server/PHP configuration may still impose limits.

### 7. No audit logging

The supplied code does not create an application-level audit trail for uploads or `.htaccess` changes.

## Recommended Hardening

For legitimate administrative use, consider adding:

1. Strong authentication and authorization.
2. CSRF protection.
3. An allowlist of permitted upload extensions.
4. MIME/content validation where appropriate.
5. A dedicated upload directory outside the web root.
6. Server configuration preventing execution of uploaded files.
7. Maximum upload-size and request limits.
8. Safe filename generation instead of trusting user-provided names.
9. Audit logging for uploads and configuration changes.
10. Restriction of `.htaccess` editing to trusted administrators.
11. Rate limiting and access controls.
12. HTTPS when deployed over a network.
13. A clear separation between uploaded content and executable application code.

## Source Structure

The supplied file is organized into these main parts:

```text
PHP upload handling
        │
        ├── POST + file detection
        ├── destination path creation
        └── move_uploaded_file()

PHP .htaccess handling
        │
        ├── POST + htc detection
        └── file_put_contents()

.htaccess loading
        │
        ├── read existing file
        └── provide default directive

HTML/CSS interface
        │
        ├── HxN//ELV display
        ├── upload form
        └── .htaccess editor

JavaScript effects
        │
        ├── HxN ↔ ELV switching
        └── glitch animation
```

## Example Default `.htaccess` Content

The application supplies the following default text when no `.htaccess` exists:

```apache
AddType application/x-httpd-php .php .phtml .php3 .php4 .php5 .php7 .php8
```

Whether this directive works depends on the Apache/PHP configuration and the permissions available to `.htaccess`.

## Status Messages

| Operation | Result |
|---|---|
| File upload succeeds | `[OK] UPLOADED` |
| `.htaccess` write succeeds | `[OK] .HTACCESS SAVED` |
| `.htaccess` cannot be written | `[FAIL] CANNOT WRITE .HTACCESS` |

## Scope

This documentation is based on the supplied PHP source code. It does not assume functionality that is not implemented in that source.

## License

No license declaration is present in the supplied source file.

If this project is intended for public distribution, add an explicit license file and corresponding project metadata.
