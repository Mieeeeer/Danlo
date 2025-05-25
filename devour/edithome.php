<?php
include 'db.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update About Sections
    $Home->updateOne(['title' => 'about-elem-home'], ['$set' => ['description' => $_POST['about_elem']]]);
    $Home->updateOne(['title' => 'about-hs-home'], ['$set' => ['description' => $_POST['about_hs']]]);

    // Update Enrollment Stats
    $Enrollment->updateOne(['title' => 'elem_female_percent'], ['$set' => ['data' => $_POST['elem_female']]]);
    $Enrollment->updateOne(['title' => 'elem_male_percent'], ['$set' => ['data' => $_POST['elem_male']]]);
    $Enrollment->updateOne(['title' => 'hs_female_percent'], ['$set' => ['data' => $_POST['hs_female']]]);
    $Enrollment->updateOne(['title' => 'hs_male_percent'], ['$set' => ['data' => $_POST['hs_male']]]);

    // Update Contact Information
    $contact_titles = ['elem_school_name', 'district_elem', 'city', 'elem_email', 'hs_school_name', 'district_hs', 'hs_email'];
    foreach ($contact_titles as $title) {
        $Contact->updateOne(['title' => $title], ['$set' => ['description' => $_POST[$title] ?? '']]);
    }

    // Update Maps
    $Contact->updateOne(['title' => 'elem_maps'], ['$set' => ['iframe_link' => $_POST['elem_map']]]);
    $Contact->updateOne(['title' => 'hs_maps'], ['$set' => ['iframe_link' => $_POST['hs_map']]]);

    // Update Announcements
    $AnnouncementLink->deleteMany([]); // Clear old entries
    foreach ($_POST['announcements'] as $iframe) {
        if (!empty(trim($iframe))) {
            $AnnouncementLink->insertOne([
                'type' => 'announcement',
                'iframe_link' => trim($iframe),
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);
        }
    }

    echo "<script>alert('Home page updated successfully.'); window.location.href='edithome.php';</script>";
    exit();
}

// Fetch current data
$aboutElem = $Home->findOne(['title' => 'about-elem-home']);
$aboutHS = $Home->findOne(['title' => 'about-hs-home']);
$enrollment = iterator_to_array($Enrollment->find(['type' => 'enrollment_data']));
$contacts = iterator_to_array($Contact->find(['type' => 'contact']));
$maps = iterator_to_array($Contact->find(['type' => 'maps']));
$announcements = iterator_to_array($AnnouncementLink->find(['type' => 'announcement']));

function getContactDesc($contacts, $title) {
    foreach ($contacts as $c) {
        if ($c['title'] === $title) return $c['description'] ?? '';
    }
    return '';
}
function getMapLink($maps, $title) {
    foreach ($maps as $m) {
        if ($m['title'] === $title) return $m['iframe_link'] ?? '';
    }
    return '';
}
function getStat($enrollment, $title) {
    foreach ($enrollment as $e) {
        if ($e['title'] === $title) return $e['data'] ?? '0%';
    }
    return '0%';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Home Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        form textarea { width: 100%; height: 100px; }
        .form-section { margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Edit Home Page Content</h1>
    <form method="POST">
        <div class="form-section">
            <h3>About Sections</h3>
            <label>About Elementary:</label>
            <textarea name="about_elem"><?= htmlspecialchars($aboutElem['description'] ?? '') ?></textarea>
            <label>About High School:</label>
            <textarea name="about_hs"><?= htmlspecialchars($aboutHS['description'] ?? '') ?></textarea>
        </div>

        <div class="form-section">
            <h3>Enrollment Stats</h3>
            <label>Elem Female %:</label><input name="elem_female" value="<?= getStat($enrollment, 'elem_female_percent') ?>">
            <label>Elem Male %:</label><input name="elem_male" value="<?= getStat($enrollment, 'elem_male_percent') ?>">
            <label>HS Female %:</label><input name="hs_female" value="<?= getStat($enrollment, 'hs_female_percent') ?>">
            <label>HS Male %:</label><input name="hs_male" value="<?= getStat($enrollment, 'hs_male_percent') ?>">
        </div>

        <div class="form-section">
            <h3>Contact Info</h3>
            <label>Elem School Name:</label><input name="elem_school_name" value="<?= getContactDesc($contacts, 'elem_school_name') ?>">
            <label>District Elem:</label><input name="district_elem" value="<?= getContactDesc($contacts, 'district_elem') ?>">
            <label>City:</label><input name="city" value="<?= getContactDesc($contacts, 'city') ?>">
            <label>Elem Email:</label><input name="elem_email" value="<?= getContactDesc($contacts, 'elem_email') ?>">
            <label>HS School Name:</label><input name="hs_school_name" value="<?= getContactDesc($contacts, 'hs_school_name') ?>">
            <label>District HS:</label><input name="district_hs" value="<?= getContactDesc($contacts, 'district_hs') ?>">
            <label>HS Email:</label><input name="hs_email" value="<?= getContactDesc($contacts, 'hs_email') ?>">
        </div>

        <div class="form-section">
            <h3>Map Iframe Links</h3>
            <label>Elem Map:</label><input name="elem_map" value="<?= getMapLink($maps, 'elem_maps') ?>">
            <label>HS Map:</label><input name="hs_map" value="<?= getMapLink($maps, 'hs_maps') ?>">
        </div>

        <div class="form-section">
            <h3>Facebook Announcements (Iframe Links)</h3>
            <?php foreach ($announcements as $i => $a): ?>
                <input name="announcements[]" value="<?= htmlspecialchars($a['iframe_link']) ?>">
            <?php endforeach; ?>
            <!-- Add 3 more empty fields for new links -->
            <?php for ($i = 0; $i < 3; $i++): ?>
                <input name="announcements[]" placeholder="New announcement iframe URL">
            <?php endfor; ?>
        </div>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
