/* Pinjam Alat Lab: JavaScript kecil untuk interaksi halaman.
   Letakkan di public/js/lab.js. Tanpa library, tanpa build. */

document.addEventListener('DOMContentLoaded', () => {
  /* 1. Konfirmasi sebelum aksi berbahaya: <form data-confirm="Hapus alat ini?"> */
  document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      if (!window.confirm(form.dataset.confirm)) e.preventDefault();
    });
  });

  /* 2. Cegah klik ganda pada form penting: <form data-once> */
  document.querySelectorAll('form[data-once]').forEach((form) => {
    form.addEventListener('submit', () => {
      const btn = form.querySelector('button[type="submit"]');
      if (!btn) return;
      setTimeout(() => {
        btn.disabled = true;
        btn.textContent = 'Memproses...';
      }, 0);
    });
  });

  /* 3. Kirim form otomatis saat nilainya berubah: <select data-autosubmit> */
  document.querySelectorAll('[data-autosubmit]').forEach((el) => {
    el.addEventListener('change', () => el.form && el.form.submit());
  });

  /* 4. Katalog: filter per lab dan pencarian, sepenuhnya di browser */
  const grid = document.querySelector('[data-catalog-grid]');
  if (grid) {
    const cards = Array.from(grid.querySelectorAll('[data-lab]'));
    const chips = Array.from(document.querySelectorAll('[data-lab-filter]'));
    const search = document.querySelector('[data-catalog-search]');
    const empty = document.querySelector('[data-empty]');
    let lab = 'all';

    const apply = () => {
      const q = (search ? search.value : '').trim().toLowerCase();
      let shown = 0;
      cards.forEach((card) => {
        const okLab = lab === 'all' || card.dataset.lab === lab;
        const okText = q === '' || card.dataset.text.includes(q);
        card.hidden = !(okLab && okText);
        if (!card.hidden) shown++;
      });
      if (empty) empty.hidden = shown !== 0;
    };

    chips.forEach((chip) => {
      chip.addEventListener('click', () => {
        lab = chip.dataset.labFilter;
        chips.forEach((c) => {
          const active = c === chip;
          c.classList.toggle('is-active', active);
          c.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        apply();
      });
    });
    if (search) search.addEventListener('input', apply);
  }

  /* 5. Tombol cetak: <button data-print> */
  document.querySelectorAll('[data-print]').forEach((btn) => {
    btn.addEventListener('click', () => window.print());
  });
});
