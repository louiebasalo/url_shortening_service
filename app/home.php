<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL shortener</title>
    <link rel="stylesheet" href="resources/css/main.css">
</head>
<style>
    
</style>
<body>
    <div class="container">
        <div class="card">
            <div class="form-section">
                <span class="title">Shorten Your URL</span>
                <div class="form-group">
                    <div class="input-group">
                        <input id="original-url" type="text" placeholder="Enter your url">
                        <object type="image/svg+xml" data="resources/img/link-svgrepo-com.svg" class="svg-input-icon"> </object>
                    </div>
                    <object type="image/svg+xml" data="resources/img/arrow-right-lg-svgrepo-com.svg" class="svg-icon" style="margin-right: 10px"> </object>
                    <div class="input-group">
                        <input id="shorten-url" type="text" readonly>
                        <object type="image/svg+xml" data="resources/img/copy-svgrepo-com.svg" class="svg-input-icon"> </object>
                    </div>
                </div>
                <div class="form-group">
                    <div id="shorten-button" class="input-group button-group">
                        <button type="submit" class="primary">Shorten</button>
                    </div>
                </div>
            </div>
            
            <div class="table-section">
                <span class="title">Shortened URLs</span>
                <table id="url-table">
                    <thead>
                        <tr>
                            <th>Original URL</th>
                            <th>Clicks</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="url-table-body">
                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td class="td-action-group">
                                <object type="image/svg+xml" data="resource/open-in-new-window-svgrepo-com.svg" class="svg-action-icon" style="width: 18px; height: 19px;"> </object>
                                <object type="image/svg+xml" data="resource/edit-3-svgrepo-com.svg" class="svg-action-icon" style="margin-top:1.5px; height: 15px"> </object>
                                <object type="image/svg+xml" data="resource/delete-svgrepo-com.svg" class="svg-action-icon" style=" height: 13px; margin-top:2.5px"> </object>
                            </td>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="resources/js/main.js"></script>
</body>
</html>

