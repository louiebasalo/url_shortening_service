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
                        <div id="copied-message"><span>✔ Copied!</span></div>
                        <input id="shortened-url" type="text" readonly>
                        <!-- <object type="image/svg+xml" data="resources/img/copy-svgrepo-com.svg" class="svg-input-icon" id="svg-copy-button"> </object> -->
                         <button id="copy-button" class="svg-input-icon"></button>
                    </div>
                </div>
                    <div id="shorten-button" class="input-group button-group ">
                        <button type="submit" class="buttons button-success button-large">Shorten</button>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="url-table-body">
                        
                    </tbody>
                </table>
                <div class="pagination-section">
                    <span id="total-entries-span">showing 10 of 50</span>
                    <div class="paginate-button-group" id="paginate-buttons-div">
                        
                    </div>
                </div>
            </div>
        </div>

        <div id="viewModal" class="modal">
            <div class="modal-content card">
                <span>close</span>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <div class="div-message">
                        <span>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                        </span>
                    </div>
                    <div class="button-group">
                        <button class="buttons button-success">Save</button>
                        <button class="buttons button-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="resources/js/main.js"></script>
</body>
</html>

