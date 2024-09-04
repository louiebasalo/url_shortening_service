

let rowsPerPage = 10;
let currentPage = 1;
let totalPages = 10;
let totalEntries = 0;

let pageSet = 5;
let pageSetStart = 1;
let pageSetEnd = pageSetStart + pageSet;

const visiblePageButtons = 9; //number of visible page buttons between the 1 and the last page.



document.addEventListener('DOMContentLoaded', () => {
    fetchData(currentPage);
    paginate_controls();

});


async function fetchData (currentPage ) {
    // console.log(`currentPage :: ${currentPage} rows :: ${rowsPerPage}`);
        const endpoint = `http://localhost:8000/api/v1/paginate?page=${currentPage}&rows=${rowsPerPage}`;

        await fetch(endpoint)
            .then(res => res.json()) //in fetch api json() converts the response into a javascript object
            .then(data => {
                populateTable(data);
                totalPages = data['meta-data']['total_page'];
                totalEntries = data['meta-data']['total_entries'];
            });

        document.getElementById('total-entries-span').textContent = `Showing ${rowsPerPage} of ${totalEntries}`;
        paginate_controls();
    }

const populateTable = (data) => {
    const table = document.getElementById('url-table');
    const tbody = table.querySelector('tbody');

    tbody.innerHTML = '';

    if(data.length === 0) return "No data";

    data['collection'].forEach(element => {
        //element.short_code and element['short_code'] both works
        const tr = document.createElement('tr');
        const td1 = document.createElement('td');
        const td2 = document.createElement('td');

        const td3 = document.createElement('td');
        td3.classList.add('td-action-group');

        const menu = document.createElement('object');
        menu.classList.add('svg-action-icon');
        menu.setAttribute('type', 'image/svg+xml');
        menu.setAttribute('data','resources/img/menu-dots-svgrepo-com.svg');
        menu.classList.add('svg-button');
        menu.classList.add('svg-button-menu-dot');

        td1.textContent = window.location.host + '/' + element.short_code;
        td2.textContent =element.clicks; 
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        td3.appendChild(menu);
        tbody.appendChild(tr)
    });
}

const shorten_url = () =>{
    const original_url = document.getElementById('original-url').value;
    const shorten_url = document.getElementById('shorten-url');

    if(original_url.trim() === '' ){
        alert("original url mandatory");
        return;
    } else {
        const endpoint = 'http://localhost:8000/api/v1/create';
        const data = {
            long_url: original_url
        };

        fetch(endpoint, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-type": "application/json"
            }
        })
        .then(res => {
            if(!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(msg => {
            if (Object.keys(msg).length === 0) {
                throw new Error('Empty response body');
            }
            try{
                shorten_url.value = window.location.host + '/' + msg.short_url;
                fetchData(currentPage, rowsPerPage )
            } catch (e) {
                console.error('Failed to parse JSON:', e);
            }
        })
        .catch(err => console.log(err));
    }
}

document.getElementById('shorten-button').addEventListener('click', shorten_url);

function createPaginationButton(text, page, isDisabled = false){
    const button = document.createElement('button');
    button.textContent = text;
    if(isDisabled){
        button.disabled = true;
    } else {
        button.onclick = () => {
            // console.log(`current page : ${page}, total page: ${totalPages} and isDisabled is: ${isDisabled}`);
            currentPage = page;
            fetchData(page);
        };
    };
    return button;
}

function createEllipsis(setPageStart){
    const ellipsis = document.createElement('button');
    ellipsis.textContent = '...';
    ellipsis.onclick = () => {
        currentPage = setPageStart;
        pageSetStart = currentPage;
        pageSetEnd = pageSetStart + pageSet;
        paginate_controls();
        fetchData(currentPage);
    }
    return ellipsis;
}

function  paginate_controls(){

    console.log(`current page : ${currentPage}, pageSetStart: ${pageSetStart} and pageSetEnd is: ${pageSetEnd}`);

    const paginationControls = document.getElementById('paginate-buttons-div');
    paginationControls.innerHTML = '';    

    if(totalPages <= visiblePageButtons){
        //show all page buttons if total pages is less than 
        for(let i = 1; i <= totalPages; i++){
            paginationControls.appendChild(createPaginationButton(i, i, i === currentPage));
        }
    } else {
        //show 1st button
        paginationControls.appendChild(createPaginationButton(1, 1, currentPage === 1));
        if(currentPage === 1 || currentPage <= pageSet){
            pageSetStart = 2;
            pageSetEnd = pageSetStart+pageSet;
        }

        if(currentPage === totalPages){
            pageSetStart = totalPages-pageSet;
            pageSetEnd = totalPages;
        }

        //ellipsis next to first  page
        if( !(currentPage - pageSet <= 1)){
            paginationControls.appendChild(createEllipsis(pageSetStart-pageSet));
        }

        //for loop to show pages in sets of 5
        for(let i = pageSetStart; i < pageSetEnd; i++){
            if(i === totalPages) break;
            paginationControls.appendChild(createPaginationButton(i, i, i === currentPage));
        }
        // put ellipsis next to last page
        if(currentPage < totalPages - pageSet){
            paginationControls.appendChild(createEllipsis(pageSetStart+pageSet));
        }

        paginationControls.appendChild(createPaginationButton(totalPages, totalPages, currentPage === totalPages ));
    }


    // if(totalPages > 1){

    //     //previouse button
    //     if(currentPage > 1){
    //         const prevButton = document.createElement('button');
    //         prevButton.textContent = '<';
    //         prevButton.onclick = () => {
    //             currentPage--;
    //             console.log(currentPage);
    //             fetchData(currentPage);
    //         }
    //         paginationControls.appendChild(prevButton);
    //     }
    //     //page numbers
    //     if(totalPages > 1){
    //         for(let i = 1; i <= totalPages; i++){
    //             const pageButton = document.createElement('button');
    //             pageButton.textContent = i;
    //             if (i === currentPage) {
    //                 pageButton.disabled = true;
    //             }
    //             pageButton.onclick = () => {
    //                 currentPage = i;
    //                 fetchData(currentPage);
    //             };
    //             paginationControls.appendChild(pageButton);
    //         }
    //     }
    //     //next button
    //     if(currentPage < totalPages){
    //         const nextButton = document.createElement('button');
    //         nextButton.textContent = '>';
    //         nextButton.onclick = () => {
    //             currentPage++;
    //             console.log(currentPage+" -- "+totalPages);
    //             fetchData(currentPage);
    //         }
    //         paginationControls.appendChild(nextButton);
    //     }
        
        
    // }
}

