// Gerekli tüm öğeleri seçme
const filterItem = document.querySelector(".items");
const filterImg = document.querySelectorAll(".gallery .image");

window.onload = () => { // pencere yüklendikten sonra
  filterItem.onclick = (selectedItem) => { // kullanıcı filterItem divine tıklarsa
    if (selectedItem.target.classList.contains("item")) { // kullanıcının seçtiği öğe .item sınıfına sahipse
      filterItem.querySelector(".active").classList.remove("active"); // ilk öğede bulunan aktif sınıfı kaldır
      selectedItem.target.classList.add("active"); // kullanıcının seçtiği öğeye aktif sınıfı ekle
      let filterName = selectedItem.target.getAttribute("data-name"); // kullanıcının seçtiği öğenin data-name değerini al ve filterName değişkenine sakla
      filterImg.forEach((image) => {
        let filterImges = image.getAttribute("data-name"); // resmin data-name değerini al
        // kullanıcının seçtiği öğenin data-name değeri resmin data-name değerine eşitse
        // veya kullanıcının seçtiği öğenin data-name değeri "all" ise
        if ((filterImges == filterName) || (filterName == "all")) {
          image.classList.remove("hide"); // resimden önce hide sınıfını kaldır
          image.classList.add("show"); // resme show sınıfını ekle
        } else {
          image.classList.add("hide"); // resme hide sınıfını ekle
          image.classList.remove("show"); // resimden show sınıfını kaldır
        }
      });
    }
  }
  for (let i = 0; i < filterImg.length; i++) {
    filterImg[i].setAttribute("onclick", "preview(this)"); // tüm mevcut resimlere onclick özelliği ekle
  }
}

// tam ekran resim önizleme fonksiyonu
// gerekli tüm öğeleri seçme
const previewBox = document.querySelector(".preview-box"),
  categoryName = previewBox.querySelector(".title p"),
  previewImg = previewBox.querySelector("img"),
  closeIcon = previewBox.querySelector(".icon"),
  shadow = document.querySelector(".shadow");

function preview(element) {
  // kullanıcı herhangi bir resme tıkladığında, sayfanın kaydırma çubuğunu kaldır, böylece kullanıcı yukarı veya aşağı kaydıramasın
  document.querySelector("body").style.overflow = "hidden";
  let selectedPrevImg = element.querySelector("img").src; // kullanıcının tıkladığı resmin kaynak bağlantısını al ve bir değişkende sakla
  let selectedImgCategory = element.getAttribute("data-name"); // kullanıcının tıkladığı resmin data-name değerini al
  previewImg.src = selectedPrevImg; // kullanıcının tıkladığı resmin kaynağını önizleme resminin kaynağına aktar
  categoryName.textContent = selectedImgCategory; // kullanıcının tıkladığı data-name değerini kategori adına aktar
  previewBox.classList.add("show"); // önizleme resmi kutusunu göster
  shadow.classList.add("show"); // açık gri arka planı göster
  closeIcon.onclick = () => { // önizleme kutusunun kapatma simgesine tıklandığında
    previewBox.classList.remove("show"); // önizleme kutusunu gizle
    shadow.classList.remove("show"); // açık gri arka planı gizle
    document.querySelector("body").style.overflow = "auto"; // sayfadaki kaydırma çubuğunu göster
  }


  let selectedEarTagNumber = element.querySelector("h4").textContent;

  // Veritabanından gelen verileri kullan
  let selectedCattle = cattleData.find(cattle => cattle.earTagNumber === selectedEarTagNumber);

  if (selectedCattle) {
    // İlgili veri bulunduğunda, cattleinfo div'ine değerleri yazdır
    let cattleinfoDiv = document.querySelector('.cattleinfo');
    cattleinfoDiv.querySelector('input[placeholder="Takma ad"]').value = selectedCattle.nickname;
    cattleinfoDiv.querySelector('input[placeholder="Tür"]').value = selectedCattle.type_name;
    cattleinfoDiv.querySelector('input[placeholder="Sarı Küpe No"]').value = selectedCattle.earTagNumber;
    cattleinfoDiv.querySelector('input[placeholder="RFID Numarası"]').value = selectedCattle.RFIDNumber;
    cattleinfoDiv.querySelector('input[placeholder="Yaşı"]').value = selectedCattle.age;
    // Diğer bilgileri de doldurabilirsin
      // Eğer inek varsa ve buy değeri true ise buy sınıfına ait div'i göster, değilse gizle
  if (selectedCattle.buy=="true") {
     cattleinfoDiv.querySelector(".buy").style.display = "block";
} else {
     cattleinfoDiv.querySelector(".buy").style.display = "none";
}
  } else {
    // İlgili kulak etiket numarasına sahip veri bulunamadığında kullanıcıya bilgi verilebilir
    console.log("İlgili hayvan verisi bulunamadı.");
  }



}


