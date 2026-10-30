# Practical 05: File Upload System

## Aim
To build a PHP web application allowing users to upload media files and store them securely on the server filesystem.

## Objective
To manage the `$_FILES` superglobal array, utilize `move_uploaded_file()`, and configure HTML form encoding for binary transfer (`multipart/form-data`).

## System Requirements
- **Software:** XAMPP Server (Apache + PHP), Code Editor, Web Browser.

## Theory & Logic
When a file is uploaded via an HTML form, the browser transmits binary data to a temporary folder on the web server. PHP populates the `$_FILES` superglobal array with details:
- `$_FILES['input_name']['name']`: Original file name.
- `$_FILES['input_name']['tmp_name']`: Temporary file path on server.
- `$_FILES['input_name']['size']`: File size in bytes.
- `$_FILES['input_name']['type']`: File MIME type.
- `$_FILES['input_name']['error']`: Upload error code.

The `move_uploaded_file()` function securely moves the temporary file to its permanent destination folder.

## Lab Setup & Procedure
1. Create a project directory containing an `uploads/` folder inside `htdocs/lab/`.
2. Ensure `uploads/` folder permissions allow write access.
3. Set HTML form attribute `enctype="multipart/form-data"`.
4. Process uploaded file via PHP using `move_uploaded_file()`.

## Algorithm
1. Render HTML form with `<input type="file" name="uploadFile">` and `enctype="multipart/form-data"`.
2. Upon submit, check `isset($_POST['submit'])`.
3. Define target directory `$target_dir = "uploads/"`.
4. Sanitize target filename using `basename($_FILES["uploadFile"]["name"])`.
5. Execute `move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)`:
   - If true: Output "The file [name] has been uploaded."
   - Else: Output "Sorry, there was an error uploading your file."

## Source Code (`upload.php`)
```php
<!DOCTYPE html>
<html>
<head>
    <title>File Upload System</title>
</head>
<body>
<h2>PHP File Upload</h2>

<form method="post" enctype="multipart/form-data">
    Select Image to Upload: 
    <input type="file" name="uploadFile" required><br><br>
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = basename($_FILES["uploadFile"]["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
        echo "<p style='color:green;'>The file <strong>" . htmlspecialchars($filename) . "</strong> has been uploaded successfully.</p>";
    } else {
        echo "<p style='color:red;'>Sorry, there was an error uploading your file.</p>";
    }
}
?>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `enctype="multipart/form-data"` | Essential form attribute enabling binary file transmission in HTTP requests. |
| `$_FILES["uploadFile"]["tmp_name"]` | Temporary server filesystem location holding the uploaded file. |
| `basename()` | Prevents path traversal security attacks by stripping directory paths from filenames. |
| `move_uploaded_file()` | Verifies that file originates from valid HTTP POST upload and moves it to target folder. |

## Expected Output & Test Cases
| Test Case # | Actions / Inputs | Expected Output |
| :---: | :--- | :--- |
| **1** | Select `photo.jpg` and click "Upload Image" | Green Message: "The file photo.jpg has been uploaded successfully." File appears in `uploads/`. |
| **2** | Submit form without choosing a file | Browser HTML5 validation prevents submission (`required` field). |
| **3** | Upload attempt when destination permissions fail | Red Message: "Sorry, there was an error uploading your file." |

## Viva Questions & Answers
**Q1. Why is `enctype="multipart/form-data"` mandatory for file upload forms?**  
*Ans:* Standard form encoding sends field values as URL-encoded strings. `multipart/form-data` splits the request into MIME parts, enabling transmission of raw binary file data.

**Q2. What information is stored inside the `$_FILES` superglobal array?**  
*Ans:* It holds file metadata including `name`, `type`, `tmp_name`, `error`, and `size`.

**Q3. What special security check does `move_uploaded_file()` perform?**  
*Ans:* It checks that the source file is a legitimate file uploaded via HTTP POST, protecting against unauthorized local file copy exploits.

**Q4. Which configuration settings in `php.ini` control file upload restrictions?**  
*Ans:* `upload_max_filesize`, `post_max_size`, `file_uploads`, and `max_file_uploads`.

**Q5. What additional security validation should be added to production upload forms?**  
*Ans:* File extension checking, MIME-type verification, maximum file size limits, renaming files to unique hashes, and disabling executable permissions in the destination folder.
