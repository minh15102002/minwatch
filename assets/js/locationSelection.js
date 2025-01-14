
// var citis = document.getElementById("city");
// var districts = document.getElementById("district");
// var wards = document.getElementById("ward");

// var Parameter = {
//     url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
//     method: "GET",
//     responseType: "application/json",
// };

// axios(Parameter)
//     .then(function(result) {
//         renderCity(result.data);
//     })
//     .catch(function(error) {
//         console.error("Error fetching data: ", error);
//     });

// function renderCity(data) {
//     for (const province of data) {
//         citis.options[citis.options.length] = new Option(province.Name, province.Name);
//     }

//     citis.onchange = function() {
//         districts.length = 1; 
//         wards.length = 1; 
//         if (this.value != "") {
//             const selectedProvince = data.find(province => province.Name === this.value);
//             for (const district of selectedProvince.Districts) {
//                 districts.options[districts.options.length] = new Option(district.Name, district.Name);
//             }
//         }
//     };

//     districts.onchange = function() {
//         wards.length = 1; 
//         const selectedProvince = data.find(province => province.Name === citis.value);
//         if (this.value != "") {
//             const selectedDistrict = selectedProvince.Districts.find(district => district.Name === this.value);
//             for (const ward of selectedDistrict.Wards) {
//                 wards.options[wards.options.length] = new Option(ward.Name, ward.Name);
//             }
//         }
//     };
// }
document.addEventListener("DOMContentLoaded", function () {
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");

    if (!citis || !districts) {
        console.error("Không tìm thấy phần tử DOM với ID 'city' hoặc 'district'.");
        return;
    }

    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "json",
    };

    axios(Parameter)
        .then(function (result) {
            renderCity(result.data);
        })
        .catch(function (error) {
            console.error("Error fetching data: ", error);
        });

    function renderCity(data) {
        for (const province of data) {
            citis.options[citis.options.length] = new Option(province.Name, province.Name);
        }

        citis.onchange = function () {
            districts.length = 1; // Reset to default option
            if (this.value != "") {
                const selectedProvince = data.find(province => province.Name === this.value);
                for (const district of selectedProvince.Districts) {
                    districts.options[districts.options.length] = new Option(district.Name, district.Name);
                }
            }
        };
    }
});
