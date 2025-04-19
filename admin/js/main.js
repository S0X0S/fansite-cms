
  // Sayfa yüklendiğinde tema kontrolü ve menü kontrolü
  document.addEventListener('DOMContentLoaded', () => {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme === 'dark') {
          document.body.classList.add('dark');
      } else {
          document.body.classList.remove('dark');
      }

      // Menü durumu kontrolü
      $("ul.a-collapse").each(function (index) {
          const isMenuOpen = localStorage.getItem(`menuOpen_${index}`) === "true";
          if (isMenuOpen) {
              $(this).removeClass("short");
              $("div.side-item-container", this).removeClass("hide animated");
          }
      });
  });

  // RTL fonksiyonu
  function rtl() {
      var body = document.body;
      body.classList.toggle("rtl");
  }

  // Dark mode fonksiyonu
  function dark() {
      var body = document.body;
      body.classList.toggle("dark");

      // Dark mode aktifse, bilgiyi localStorage'a kaydet
      if (body.classList.contains('dark')) {
          localStorage.setItem('theme', 'dark');
      } else {
          localStorage.setItem('theme', 'light');
      }
  }














document.addEventListener('DOMContentLoaded', function () {
    // Sayfa yüklendiğinde her menünün durumunu kontrol et
    document.querySelectorAll('ul.a-collapse').forEach(function (menu) {
        const menuId = menu.getAttribute('data-menu-id');
        const menuStatus = localStorage.getItem(`${menuId}MenuOpen`);

        if (menuStatus === 'true') {
            const container = menu.querySelector('.side-item-container');
            menu.classList.remove('short');
            container.classList.remove('hide', 'animated');
        } else {
            const container = menu.querySelector('.side-item-container');
            menu.classList.add('short');
            container.classList.add('hide', 'animated');
        }
    });

    // Sayfa yüklendiğinde seçili menü öğesini kontrol et (localStorage)
    const selectedMenuItemHref = localStorage.getItem('selectedMenuItem');
    if (selectedMenuItemHref) {
        const selectedMenuItem = document.querySelector(`a[href="${selectedMenuItemHref}"]`);
        if (selectedMenuItem) {
            selectedMenuItem.closest('.side-item').classList.add('selected'); // 'side-item' öğesine sadece 'selected' sınıfı ekle
        }
    }

    // Sayfa yüklendiğinde URL ile menü öğesini kontrol et
    const currentPage = window.location.pathname; // Mevcut sayfanın URL'si
    document.querySelectorAll('.side-item').forEach(function (item) {
        const link = item.querySelector('a');
        if (link && link.getAttribute('href') === currentPage) {
            item.classList.add('selected'); // 'side-item' öğesine sadece 'selected' sınıfı ekle
        }
    });
});

// Menü öğesine tıklandığında sadece side-item seçili durumu kaydetme
function selectMenuItem(element) {
    // Diğer tüm menü öğelerinden 'selected' sınıfını kaldır
    document.querySelectorAll('.side-item').forEach(function (item) {
        item.classList.remove('selected');
    });

    // Tıklanan öğe olan 'side-item' öğesine sadece 'selected' sınıfını ekle
    element.closest('.side-item').classList.add('selected'); // 'side-item' öğesine sadece 'selected' sınıfını ekle

    // Tıklanan menü öğesinin href'ini localStorage'a kaydet
    localStorage.setItem('selectedMenuItem', element.getAttribute('href'));
}

// Menü açma/kapama durumunu kaydetmek için
function toggleMenu(element) {
    const menu = element.closest('.a-collapse');
    const container = menu.querySelector('.side-item-container');
    const menuId = menu.getAttribute('data-menu-id');

    // Menü açma/kapama işlemi
    menu.classList.toggle('short');
    container.classList.toggle('hide');
    container.classList.toggle('animated');

    // Menü durumunu kaydet
    const isOpen = !container.classList.contains('hide');
    localStorage.setItem(`${menuId}MenuOpen`, isOpen);
}




document.addEventListener('DOMContentLoaded', function () {
    const loadingSpinner = document.getElementById('loading-spinner');
    const progressBar = document.createElement('div');
    progressBar.classList.add('progress-bar');
    document.body.appendChild(progressBar); // Çubuğu sayfaya ekle

    let progress = 0; // Başlangıçta ilerleme sıfır
    const interval = setInterval(function () {
        progress += 1; // Yüklenme ilerledikçe artar
        progressBar.style.width = progress + '%'; // Çubuğun genişliğini güncelle
        if (progress >= 100) {
            clearInterval(interval); // Çubuk %100'e ulaşınca durdur
        }
    }, 30); // Her 30 ms'de bir ilerlemeyi artır

    // Sayfa tamamen yüklendikten sonra yüklenme simgesini gizle
    window.onload = function () {
        setTimeout(function () {
            loadingSpinner.style.display = 'none'; // Yüklenme simgesini gizle
            progressBar.style.display = 'none'; // Yüklenme çubuğunu gizle
        }, 500); // 0.5 saniye sonra simgeleri gizle
    };
});


































  // Grafik oluşturma kodları
  var ctx = document.getElementById('myChart2');
  var ctx = new Chart(ctx, {
      type: 'polarArea',
      data: {
          labels: ['Red', 'Green', 'Yellow', 'Grey', 'Blue'],
          datasets: [{
              label: '# of Votes',
              data: [6, 8, 5, 2, 3],
              backgroundColor: [
                  '#ff6384',
                  '#4bc0c0',
                  '#ffcd56',
                  '#c9cbcf',
                  '#36a2eb',
              ]
          }]
      },
      options: {}
  });

  var myChart4 = document.getElementById('myChart4');
  var myChart4 = new Chart(myChart4, {
      type: 'doughnut',
      data: {
          labels: ['Red', 'Green', 'Yellow', 'Grey', 'Blue'],
          datasets: [{
              label: '# of Votes',
              data: [6, 8, 5, 2, 3],
              backgroundColor: [
                  '#ff6384',
                  '#4bc0c0',
                  '#ffcd56',
                  '#c9cbcf',
                  '#36a2eb',
              ]
          }]
      },
      options: {}
  });

  var mixChart = document.getElementById('myChart5');
  var mixedChart = new Chart(mixChart, {
      type: 'bar',
      data: {
          labels: ['Red', 'Green', 'Yellow', 'Grey', 'Blue', 'Red', 'Green', 'Yellow', 'Grey', 'Blue'],
          datasets: [{
              label: 'Bar Dataset',
              data: [6, 8, 5, 2, 3, 10, 20, 30, 40, 50],
              backgroundColor: [
                  '#ff6384',
                  '#4bc0c0',
                  '#ffcd56',
                  '#c9cbcf',
                  '#36a2eb',
                  '#ff6384',
                  '#4bc0c0',
                  '#ffcd56',
                  '#c9cbcf',
                  '#36a2eb',
              ]
          }, {
              label: 'Line Dataset',
              data: [8, 12, 6, 3, 5, 12, 20, 30, 44, 60],
              type: 'line'
          }],
      },
      options: {}
  });

