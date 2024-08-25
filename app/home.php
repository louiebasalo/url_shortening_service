<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL shortener</title>
</head>
<style>
    body {
        margin: 0;
        font-family: montserrat, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f4f4f4;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .card {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 800px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .form-section {
        padding: 20px 20px 0 20px;
        box-sizing: border-box;
    }

    .form-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .svg-input-icon {
        position: absolute;
        width: 20px;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    .svg-action-icon {
        width: 15px;
        height: 15px;
    }

   
    .svg-icon {
        width: 25px;
        height: 25px;
    }

    .td-action-group {
        position: relative;
        display: flex;
        flex-direction: row ;
        justify-content: flex-end;
        gap: 15px;
    }

    .input-group {
        position: relative;
        display: flex;
        flex: 1;
    }

    .button-group {
        position: relative;
        width: 100%;
        flex-direction: row;
        justify-content: flex-end;
        display: flex;
    }

    .form-group {
        margin-bottom: 10px;
        width: 100%;
    }

    input[type="text"] {
        width: 100%;
        flex: 1;
        padding: 15px 33px 13px 20px ;
        border: 1px solid #ddd;
        border-radius: 25px;
        margin-right: 10px;
        box-sizing: border-box;
        font-size: 16px;
        color: #009973;
    }

    input[type="text"]:focus {
        /* border: 1.5px solid #ddd; */

        border-color: #008060; /* Change border color on focus */
        outline: none; /* Remove default focus outline */
    }

    .title {
        font-size: 17px;
        font-weight: 420;
        color: #4d4d4d;
        display: block;
        margin-bottom: 10px;
    }   

    .primary {
        width: 200px;
    }

    button {
        font-weight: 500 !important;
        font-size: 16px;
        padding: 15px 20px 13px 20px ;
        margin-right: 10px;
        background-color: #009973;
        border: none;
        border-radius: 25px;
        color: #fff;
        cursor: pointer;
    }

    button:hover {
        background-color: #008060;
    }

    .table-section {
        padding: 20px;
        box-sizing: border-box;
    }

    .table-section table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        color: #4d4d4d;
    }

    .table-section th, .table-section td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .table-section th {
        background-color: #f8f9fa;font-size: 15px;
        font-weight: 420;
        color: #4d4d4d;
        margin-bottom: 10px;
    }

    .table-section tr:hover {
        background-color: #f1f1f1;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .form-group {
            flex-direction: column;
        }

        input[type="text"] {
            margin-right: 0;
            margin-bottom: 10px;
            width: 100%;
        }

        button {
            width: 100%;
        }
    }

</style>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="form-section">
                <span class="title">Shorten Your URL</span>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" placeholder="Enter your url">
                        <object type="image/svg+xml" data="resource/link-svgrepo-com.svg" class="svg-input-icon"> </object>
                    </div>
                    <object type="image/svg+xml" data="resource/arrow-right-lg-svgrepo-com.svg" class="svg-icon" style="margin-right: 10px"> </object>
                    <div class="input-group">
                        <input type="text" readonly>
                        <object type="image/svg+xml" data="resource/copy-svgrepo-com.svg" class="svg-input-icon"> </object>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group button-group">
                        <button type="submit" class="primary">Shorten</button>
                    </div>
                </div>
            </div>
            
            <div class="table-section">
                <span class="title">Shortened URLs</span>
                <table>
                    <thead>
                        <tr>
                            <th>Original URL</th>
                            <th>Clicks</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="url-table-body">
                        <?php
                            $my_url = new \Config();
                            $my_url = $my_url();
                            foreach($data as $key => $value){
                        ?>
                            <tr>
                                <td>
                                    <?php echo $my_url['MY_URL'] . $value['short_code']; ?>
                                </td>
                                <td>
                                    <?php echo $value['clicks']?>
                                </td>
                                <td class="td-action-group">
                                    <object type="image/svg+xml" data="resource/open-in-new-window-svgrepo-com.svg" class="svg-action-icon" style="width: 18px; height: 19px;"> </object>
                                    <object type="image/svg+xml" data="resource/edit-3-svgrepo-com.svg" class="svg-action-icon" style="margin-top:1.5px; height: 15px"> </object>
                                    <object type="image/svg+xml" data="resource/delete-svgrepo-com.svg" class="svg-action-icon" style=" height: 13px; margin-top:2.5px"> </object>
                                </td>
                            <tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

</body>
</html>