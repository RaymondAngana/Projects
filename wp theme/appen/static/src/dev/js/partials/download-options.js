export default () => {
    const popups = document.querySelectorAll('.dataset-popup');
    if (!popups.length) return;

    const downloadOptions = document.querySelectorAll('.download-option');

    const overlay = document.createElement('div');
    overlay.classList.add('popup-overlay');
    overlay.innerHTML = `
    <div class="popup">
        <div class="popup-body">
            <div class="popup-content"></div>
        </div>
        <div class="popup-close"></div>
    </div>
  `;
    document.body.appendChild(overlay);
    const overlayContent = overlay.querySelector('.popup-content');

    downloadOptions.forEach(option => {
        const link = option.querySelector('.open-dataset-info');
        if (!link) return;
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.documentElement.classList.add('js-no-scroll');
            const preview = option.nextElementSibling.cloneNode(true);
            overlayContent.appendChild(preview);
            overlay.style.display = 'flex';
            preview.style.display = 'block';
            initDatasetTabs();
        });
    });

    function initDatasetTabs() {
        const tabWrappers = document.querySelectorAll('.dataset-popup .tabs');
        if (!tabWrappers) return;
        tabWrappers.forEach(tabWrapper => {
            const tabs = tabWrapper.querySelectorAll('li > a');
            const tabContentWrap = tabWrapper.nextElementSibling;
            const tabContents = tabContentWrap.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault;
                    tabs.forEach(el => {
                        el.parentNode.classList.remove('is-active');
                    });
                    tabContents.forEach(el => {
                        el.classList.remove('is-active');
                    });
                    const target = this.getAttribute('data-tabs-target');
                    const tabContent = tabContentWrap.querySelector(`#${target}`);
                    this.parentNode.classList.add('is-active');
                    tabContent.classList.add('is-active');
                });
            });
        });
    }

    const closePopup = document.querySelector('.popup-close');
    closePopup.addEventListener('click', () => {
        overlay.style.display = 'none';
        overlayContent.innerHTML = '';
        document.documentElement.classList.remove('js-no-scroll');
    });
};