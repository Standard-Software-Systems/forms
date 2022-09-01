var createForm = document.getElementById("createForm1");
if(createForm) {
createForm.addEventListener("submit", async function(e) {
    e.preventDefault();
})
}
var submitForm = document.getElementById("submitForm");
if(submitForm) {
    submitForm.addEventListener("submit", async function(e) {
    e.preventDefault();
})
}
var subForm = document.getElementById("subForm");
if(subForm) {
    subForm.addEventListener("submit", async function(e) {
    e.preventDefault();
})
}
var replyForm = document.getElementById("replyForm");
if(replyForm) {
    replyForm.addEventListener("submit", async function(e) {
    e.preventDefault();
})
}
var webhookUpdate = document.getElementById("webhookUpdate");
if(webhookUpdate) {
    webhookUpdate.addEventListener("submit", async function(e) {
    e.preventDefault();
})
}
var editForm = document.getElementById("editForm");
if(editForm) {
    editForm.addEventListener("submit", async function(e) {
    e.preventDefault();
})
}


var replies = document.getElementById("replies1");
if(replies) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let page = urlParams.get('id');
    let fid;
    if(urlParams.has("id")) {
        fid = page;
    } else { fid = "none" }
    setInterval(async () => {
       let xhr = new XMLHttpRequest();
       xhr.open("POST", "../backend/replies.inc.php?subId="+fid, true);
       xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                replies.innerHTML = data;
            }
        }
       } 
       xhr.send();
    }, 500);
}

$("#createForm1 .createBtn").on("click", async function (e) {
    e.preventDefault();
    const questions = document.querySelectorAll("#question");
    let filled = true;
    questions.forEach(async function (q) {
        if(q.value.length < 1) {
            filled = false;
        }
    });
    if(!filled) {
        document.getElementById("createFormErrorText").innerText = "All input fields must be filled";
    } else {


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../backend/createform.inc.php", true);
    xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {   
        if (xhr.status === 200) {
                let data = xhr.response;
                // console.log(data);
                data = JSON.parse(data);
                document.getElementById("createFormErrorText").innerText = ""
                document.getElementById("createFormSuccessText").innerText = ""
                if(data.error) {
                    document.getElementById("createFormErrorText").innerText = data.message
                } else {
                    window.location.href = "../forms/index.php?id=" + data.id
                }
            }
        }
    }
    let formData = new FormData(createForm);
    xhr.send(formData);
}
});
$(".editForm").on("click", async function (e) {
    e.preventDefault();
    const questions = document.querySelectorAll("#question");
    let filled = true;
    questions.forEach(async function (q) {
        if(q.value.length < 1) {
            filled = false;
        }
    });
    if(!filled) {
        document.getElementById("createFormErrorText").innerText = "All input fields must be filled";
    } else {


    let xhr = new XMLHttpRequest();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let page = urlParams.get('id');
    let fid;
    if(urlParams.has("id")) {
        fid = page;
    } else { fid = "none" }
    xhr.open("POST", "../backend/editform.inc.php?id="+fid, true);
    xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {   
        if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                data = JSON.parse(data);
                document.getElementById("createFormErrorText").innerText = ""
                document.getElementById("createFormSuccessText").innerText = ""
                if(data.error) {
                    document.getElementById("createFormErrorText").innerText = data.message
                } else {
                    document.getElementById("createFormSuccessText").innerText = data.message
                    setTimeout(() => {
                    window.location.href = "../forms/index.php?id=" + data.id
                    }, 3000);
                }
            }
        }
    }
    let formData = new FormData(editForm);
    xhr.send(formData);
}
});
$("#submitBtn").on("click", async function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let page = urlParams.get('id');
    let fid;
    if(urlParams.has("id")) {
        fid = page;
    } else { fid = "none" }
    console.log(fid);
    xhr.open("POST", "../backend/submitform.inc.php?formId="+fid, true);
    xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {   
        if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                data = JSON.parse(data);
                document.getElementById("submitFormErrorText").innerText = ""
                if(data.error) {
                    document.getElementById("submitFormErrorText").innerText = data.message
                } else {
                    document.getElementById("submitFormSuccessText").innerText = "Your submission has been created. You will be redirected to your submission in 4 seconds."
                    setTimeout(() => {
                    window.location.href = "../submissions/index.php?id=" + data.id
                    }, 3000);
                }
            }
        }
    }
    let formData = new FormData(submitForm);
    xhr.send(formData);
});
$("#saveBtn").on("click", async function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let page = urlParams.get('id');
    let fid;
    if(urlParams.has("id")) {
        fid = page;
    } else { fid = "none" }
    console.log(fid);
    xhr.open("POST", "../backend/updatesub.inc.php?id="+fid, true);
    xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {   
        if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                data = JSON.parse(data);
                document.getElementById("saveFormErrorText").innerText = ""
                if(data.error) {
                    document.getElementById("saveFormErrorText").innerText = data.message
                } else {
                    window.location.reload();
                }
            }
        }
    }
    let formData = new FormData(subForm);
    xhr.send(formData);
});

$("#repBtn").on("click", async function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let page = urlParams.get('id');
    let fid;
    if(urlParams.has("id")) {
        fid = page;
    } else { fid = "none" }
    console.log(fid);
    xhr.open("POST", "../backend/sendreply.inc.php?id="+fid, true);
    xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {   
        if (xhr.status === 200) {
                let data = xhr.response;
                // console.log(data);
                data = JSON.parse(data);
                document.getElementById("sendReplyErrorText").innerText = ""
                if(data.error) {
                    document.getElementById("sendReplyErrorText").innerText = data.message
                } else {
                    document.getElementById("rep").value = "";
                    document.getElementById("rep").innerText = "";
                    document.getElementById("rep").innerHTML = "";
                    // window.location.reload();
                }
            }
        }
    }
    let formData = new FormData(replyForm);
    xhr.send(formData);
});

$(".updateWebBtn").on("click", async function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../backend/formUpdate.inc.php", true);
    xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {   
        if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
                data = JSON.parse(data);
                // document.getElementById("sendReplyErrorText").innerText = ""
                if(data.error) {
                    // document.getElementById("sendReplyErrorText").innerText = data.message
                } else {
                    window.location.reload();
                }
            }
        }
    }
    let formData = new FormData(webhookUpdate);
    xhr.send(formData);
});
$("#addQuestions").on("click", async function(e) {
    e.preventDefault();
})

let curr = 1;
async function addQuestion() {
    var qid = makeid(10);
    var element = document.getElementById("questions");
    var parentdiv = document.createElement("div");
    var label = document.createElement("label");
    var input = document.createElement("input");
    var select = document.createElement("select");
    var option1 = document.createElement("option");
    option1.innerText = "Input Field";
    option1.setAttribute("value", "input");
    var option2 = document.createElement("option");
    option2.innerText = "Select Menu";
    option2.setAttribute("value", "select");
    select.appendChild(option1);
    select.appendChild(option2);
    select.name = "type[]";
    select.id = "typeSelect";
    select.classList.add("typeSelect")
    select.setAttribute("onchange", "getval(this);");
    curr++;
    parentdiv.className = "questionadded mb-3";
    label.innerHTML = "Question " + curr;
    label.className = "form-label text-center"
    var br = document.createElement("br");
    input.className = "questionInput bg-transparent inputField";
    input.placeholder = "Enter a question...";
    input.id = `question`;
    input.name = `question[]`;
    input.type = "text";
    input.setAttribute("required", "");
    parentdiv.appendChild(label);
    parentdiv.appendChild(br);
    parentdiv.appendChild(input);
    parentdiv.appendChild(select);
    element.appendChild(parentdiv);
}

let curr1 = Number($("#currEditor").val());
async function addQuestionEditor() {
    var qid = makeid(10);
    var element = document.getElementById("questions");
    var parentdiv = document.createElement("div");
    var label = document.createElement("label");
    var input = document.createElement("input");
    var select = document.createElement("select");
    var option1 = document.createElement("option");
    option1.innerText = "Input Field";
    option1.setAttribute("value", "input");
    var option2 = document.createElement("option");
    option2.innerText = "Select Menu";
    option2.setAttribute("value", "select");
    select.appendChild(option1);
    select.appendChild(option2);
    select.name = "type[]";
    select.id = "typeSelect";
    select.classList.add("typeSelect")
    select.setAttribute("onchange", "getval(this);");
    curr1++;
    parentdiv.className = "questionadded mb-3";
    label.innerHTML = "Question " + curr1;
    label.className = "form-label text-center"
    var br = document.createElement("br");
    input.className = "questionInput bg-transparent inputField";
    input.placeholder = "Enter a question...";
    input.id = `question`;
    input.name = `question[]`;
    input.type = "text";
    input.setAttribute("required", "");
    parentdiv.appendChild(label);
    parentdiv.appendChild(br);
    parentdiv.appendChild(input);
    parentdiv.appendChild(select);
    element.appendChild(parentdiv);
}
function getval(input) {
    var element = input.parentNode;
    const i = element.querySelector("input");
    const s = element.querySelector("select");
    if (input.value === "select") {
        element.removeChild(s);
        var select = document.createElement("select");
        var option1 = document.createElement("option");
        option1.innerText = "Select Menu";
        option1.setAttribute("value", "select");
        var option2 = document.createElement("option");
        option2.innerText = "Input Field";
        option2.setAttribute("value", "input");
        select.appendChild(option1);
        select.appendChild(option2);
        select.name = "type[]";
        select.id = "select-" + curr;
        select.classList.add("typeSelect")
        select.setAttribute("onchange", "getval(this);");
        var i1 = document.createElement("textarea");
        i1.className = "questionInput bg-transparent inputField mt-2";
        i1.placeholder = "Seperate each option with comma...";
        i1.id = `options options[]`;
        i1.name = `options[]`;
        i1.type = "text";
        element.appendChild(i1);
        element.appendChild(select);
    }
}
async function removeQuestion() {
    var element = document.getElementById("questions");
    if (element.children.length > 1) {
        element.removeChild(element.lastChild);
        curr1 = curr1 - 1;
        curr = curr - 1;
    }
}
function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
};