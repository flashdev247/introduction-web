(() => {
  const CART_KEY = "httm_cart_v1";
  const CART_META_KEY = "httm_cart_meta_v1";
  const MIN_ORDER_TOTAL = 500000;
  const ADDRESS_API_BASE = "https://provinces.open-api.vn/api/v2";

  const formatMoney = (value) => `${Number(value || 0).toLocaleString("vi-VN")}đ`;

  const getCart = () => {
    try {
      const cart = JSON.parse(localStorage.getItem(CART_KEY) || "[]");
      return Array.isArray(cart) ? cart : [];
    } catch {
      return [];
    }
  };

  const setCart = (cart) => localStorage.setItem(CART_KEY, JSON.stringify(cart));

  const getCartMeta = () => {
    try {
      return JSON.parse(localStorage.getItem(CART_META_KEY) || "{}");
    } catch {
      return {};
    }
  };

  const setCartMeta = (meta) => localStorage.setItem(CART_META_KEY, JSON.stringify(meta));

  const getCartTotal = () => getCart().reduce((sum, item) => sum + item.price * item.quantity, 0);
  const getCartCount = () => getCart().reduce((sum, item) => sum + item.quantity, 0);

  const refreshHeaderCartCount = () => {
    document.querySelectorAll("[data-cart-count]").forEach((el) => {
      el.textContent = String(getCartCount());
    });
  };

  const upsertCartItem = (payload) => {
    const cart = getCart();
    const idx = cart.findIndex((i) => i.id === payload.id);
    if (idx === -1) {
      cart.push(payload);
    } else {
      cart[idx].quantity += payload.quantity;
    }
    setCart(cart);
    refreshHeaderCartCount();
  };

  const setupProductPurchase = () => {
    const root = document.querySelector("[data-product-purchase]");
    if (!root) return;

    const qtyInput = root.querySelector("[data-qty-input]");
    const minusBtn = root.querySelector("[data-qty-minus]");
    const plusBtn = root.querySelector("[data-qty-plus]");
    const addBtn = root.querySelector("[data-add-to-cart]");
    const product = {
      id: Number(root.dataset.productId),
      name: root.dataset.productName || "",
      price: Number(root.dataset.productPrice || 0),
      image: root.dataset.productImage || "",
    };

    minusBtn?.addEventListener("click", () => {
      qtyInput.value = String(Math.max(1, Number(qtyInput.value || 1) - 1));
    });
    plusBtn?.addEventListener("click", () => {
      qtyInput.value = String(Math.max(1, Number(qtyInput.value || 1) + 1));
    });

    addBtn?.addEventListener("click", () => {
      const quantity = Math.max(1, Number(qtyInput.value || 1));
      upsertCartItem({ ...product, quantity });
      addBtn.textContent = "Đã thêm vào giỏ";
      setTimeout(() => {
        addBtn.textContent = "Thêm vào giỏ hàng";
      }, 1200);
    });
  };

  const setupCartPage = () => {
    const page = document.querySelector("[data-cart-page]");
    if (!page) return;

    const itemsWrap = page.querySelector("[data-cart-items]");
    const summary = page.querySelector("[data-cart-summary]");
    const totalEl = page.querySelector("[data-cart-total]");
    const noteEl = page.querySelector("[data-order-note]");
    const invoiceToggle = page.querySelector("[data-invoice-toggle]");
    const invoiceForm = page.querySelector("[data-invoice-form]");
    const checkoutBtn = page.querySelector("[data-cart-checkout]");

    const confirmModal = document.querySelector("[data-invoice-confirm-modal]");
    const confirmNo = confirmModal?.querySelector("[data-invoice-confirm-no]");
    const confirmYes = confirmModal?.querySelector("[data-invoice-confirm-yes]");

    const meta = getCartMeta();
    noteEl.value = meta.note || "";
    if (meta.invoice?.wants_invoice) {
      invoiceToggle.checked = true;
      invoiceForm.style.display = "block";
      page.querySelector("[data-invoice-company]").value = meta.invoice.invoice_company || "";
      page.querySelector("[data-invoice-tax-code]").value = meta.invoice.invoice_tax_code || "";
      page.querySelector("[data-invoice-email]").value = meta.invoice.invoice_email || "";
      page.querySelector("[data-invoice-address]").value = meta.invoice.invoice_address || "";
    }

    const persistMeta = () => {
      setCartMeta({
        ...getCartMeta(),
        note: noteEl.value || "",
        invoice: {
          wants_invoice: !!invoiceToggle.checked,
          invoice_company: page.querySelector("[data-invoice-company]").value || "",
          invoice_tax_code: page.querySelector("[data-invoice-tax-code]").value || "",
          invoice_email: page.querySelector("[data-invoice-email]").value || "",
          invoice_address: page.querySelector("[data-invoice-address]").value || "",
        },
      });
    };

    const render = () => {
      const cart = getCart();
      summary.textContent = `Bạn đang có ${cart.length} sản phẩm trong giỏ hàng`;
      itemsWrap.innerHTML = "";

      cart.forEach((item) => {
        const row = document.createElement("div");
        row.style.border = "1px solid var(--line)";
        row.style.borderRadius = "8px";
        row.style.padding = "12px";
        row.style.display = "grid";
        row.style.gridTemplateColumns = "76px minmax(0, 1fr) auto";
        row.style.gap = "14px";
        row.style.alignItems = "center";
        row.style.background = "#fff";
        row.innerHTML = `
          <img src="${item.image || ""}" alt="" style="width:76px;height:76px;object-fit:cover;background:#f4f1ec;border-radius:6px;">
          <div style="min-width:0;">
            <strong style="font-size:16px; line-height:1.35; display:block; font-weight:700;">${item.name}</strong>
            <div class="muted" style="font-size:15px; margin-top:4px;">${formatMoney(item.price)}</div>
          </div>
          <div style="display:flex;align-items:center;gap:6px;">
            <button type="button" class="btn btn-outline" data-action="decrease" style="height:34px; min-width:34px; padding:0; border-radius:4px;">-</button>
            <span style="min-width:24px; text-align:center; font-weight:600;">${item.quantity}</span>
            <button type="button" class="btn btn-outline" data-action="increase" style="height:34px; min-width:34px; padding:0; border-radius:4px;">+</button>
            <button type="button" class="btn btn-outline" data-action="remove" style="height:34px; min-width:34px; padding:0; border-radius:4px;">x</button>
          </div>
        `;
        row.querySelector('[data-action="decrease"]').addEventListener("click", () => {
          const next = getCart().map((x) => x.id === item.id ? { ...x, quantity: Math.max(1, x.quantity - 1) } : x);
          setCart(next); refreshHeaderCartCount(); render();
        });
        row.querySelector('[data-action="increase"]').addEventListener("click", () => {
          const next = getCart().map((x) => x.id === item.id ? { ...x, quantity: x.quantity + 1 } : x);
          setCart(next); refreshHeaderCartCount(); render();
        });
        row.querySelector('[data-action="remove"]').addEventListener("click", () => {
          const next = getCart().filter((x) => x.id !== item.id);
          setCart(next); refreshHeaderCartCount(); render();
        });
        itemsWrap.appendChild(row);
      });

      const total = getCartTotal();
      totalEl.textContent = formatMoney(total);
      checkoutBtn.disabled = total < MIN_ORDER_TOTAL || cart.length === 0;
      checkoutBtn.style.opacity = checkoutBtn.disabled ? "0.6" : "1";
    };

    invoiceToggle?.addEventListener("change", () => {
      invoiceForm.style.display = invoiceToggle.checked ? "block" : "none";
      persistMeta();
    });
    noteEl?.addEventListener("input", persistMeta);
    ["[data-invoice-company]", "[data-invoice-tax-code]", "[data-invoice-email]", "[data-invoice-address]"]
      .forEach((selector) => page.querySelector(selector)?.addEventListener("input", persistMeta));

    checkoutBtn?.addEventListener("click", () => {
      persistMeta();
      if (invoiceToggle.checked) {
        confirmModal.style.display = "block";
        return;
      }
      window.location.href = "/checkout";
    });

    confirmNo?.addEventListener("click", () => {
      invoiceToggle.checked = false;
      invoiceForm.style.display = "none";
      persistMeta();
      confirmModal.style.display = "none";
      window.location.href = "/checkout";
    });
    confirmYes?.addEventListener("click", () => {
      persistMeta();
      confirmModal.style.display = "none";
      window.location.href = "/checkout";
    });

    render();
  };

  const setupCheckoutPage = () => {
    const page = document.querySelector("[data-checkout-page]");
    if (!page) return;

    const cart = getCart();
    const meta = getCartMeta();
    const form = page.querySelector("[data-checkout-form]");
    const itemsWrap = page.querySelector("[data-checkout-items]");
    const totalEl = page.querySelector("[data-checkout-total]");
    const invoiceToggle = page.querySelector("[data-checkout-invoice-toggle]");
    const invoiceForm = page.querySelector("[data-checkout-invoice-form]");
    const provinceSelect = page.querySelector("[data-province-select]");
    const communeSelect = page.querySelector("[data-commune-select]");
    const statusEl = page.querySelector("[data-address-api-status]");

    const total = getCartTotal();
    totalEl.textContent = formatMoney(total);
    itemsWrap.innerHTML = cart.map((item) =>
      `<div style="display:flex;justify-content:space-between;gap:12px;font-size:15px;"><span>${item.name} x ${item.quantity}</span><strong>${formatMoney(item.quantity * item.price)}</strong></div>`
    ).join("");

    if (meta?.note) {
      const noteField = form.querySelector('[name="note"]');
      if (noteField) noteField.value = meta.note;
    }
    if (meta?.invoice?.wants_invoice) {
      invoiceToggle.checked = true;
      invoiceForm.style.display = "block";
      Object.entries(meta.invoice).forEach(([key, value]) => {
        const field = form.querySelector(`[name="${key}"]`);
        if (field && typeof value === "string") field.value = value;
      });
    }

    const persistCheckoutInvoice = () => {
      const current = getCartMeta();
      setCartMeta({
        ...current,
        note: form.querySelector('[name="note"]')?.value || current.note || "",
        invoice: {
          wants_invoice: !!invoiceToggle.checked,
          invoice_company: form.querySelector('[name="invoice_company"]')?.value || "",
          invoice_tax_code: form.querySelector('[name="invoice_tax_code"]')?.value || "",
          invoice_email: form.querySelector('[name="invoice_email"]')?.value || "",
          invoice_address: form.querySelector('[name="invoice_address"]')?.value || "",
        },
      });
    };

    invoiceToggle?.addEventListener("change", () => {
      invoiceForm.style.display = invoiceToggle.checked ? "block" : "none";
      persistCheckoutInvoice();
    });
    ["invoice_company", "invoice_tax_code", "invoice_email", "invoice_address"]
      .forEach((name) => form.querySelector(`[name="${name}"]`)?.addEventListener("input", persistCheckoutInvoice));

    const fillAddressData = (target, options, placeholder) => {
      target.innerHTML = `<option value="">${placeholder}</option>`;
      options.forEach((item) => {
        const op = document.createElement("option");
        op.value = item.code;
        op.textContent = item.name;
        op.dataset.name = item.name;
        target.appendChild(op);
      });
    };

    const fetchJson = async (url) => {
      const res = await fetch(url);
      if (!res.ok) throw new Error("Address API error");
      return res.json();
    };

    const loadProvinces = async () => {
      statusEl.textContent = "Đang tải danh sách tỉnh/thành...";
      const data = await fetchJson(`${ADDRESS_API_BASE}/?depth=1`);
      const provinces = Array.isArray(data) ? data : (data.provinces || data.data || []);
      fillAddressData(provinceSelect, provinces, "Chọn Tỉnh/Thành phố");
      statusEl.textContent = "";
    };

    const loadCommunes = async (provinceCode) => {
      communeSelect.disabled = true;
      fillAddressData(communeSelect, [], "Chọn Phường/Xã");
      if (!provinceCode) return;
      statusEl.textContent = "Đang tải danh sách phường/xã...";
      const data = await fetchJson(`${ADDRESS_API_BASE}/p/${provinceCode}?depth=2`);
      const wards = data.wards || data.communes || [];
      fillAddressData(communeSelect, wards, "Chọn Phường/Xã");
      communeSelect.disabled = false;
      statusEl.textContent = "";
    };

    loadProvinces().catch(() => {
      statusEl.textContent = "Không tải được danh sách địa chỉ, vui lòng thử lại.";
    });

    provinceSelect.addEventListener("change", () => {
      loadCommunes(provinceSelect.value).catch(() => {
        statusEl.textContent = "Không tải được danh sách phường/xã, vui lòng thử lại.";
      });
    });

    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      if (cart.length === 0 || total < MIN_ORDER_TOTAL) {
        window.AppToast?.error("Đơn hàng chưa đủ điều kiện thanh toán (tối thiểu 500.000đ).");
        return;
      }

      const provinceOption = provinceSelect.options[provinceSelect.selectedIndex];
      const communeOption = communeSelect.options[communeSelect.selectedIndex];
      form.querySelector('[name="province_name"]').value = provinceOption?.dataset?.name || "";
      form.querySelector('[name="commune_name"]').value = communeOption?.dataset?.name || "";

      persistCheckoutInvoice();

      const payload = Object.fromEntries(new FormData(form).entries());
      payload.wants_invoice = !!invoiceToggle.checked;
      payload.invoice_company = form.querySelector('[name="invoice_company"]')?.value || "";
      payload.invoice_tax_code = form.querySelector('[name="invoice_tax_code"]')?.value || "";
      payload.invoice_email = form.querySelector('[name="invoice_email"]')?.value || "";
      payload.invoice_address = form.querySelector('[name="invoice_address"]')?.value || "";
      payload.items = cart.map((item) => ({ product_id: item.id, quantity: item.quantity }));

      const csrf = document.querySelector('meta[name="csrf-token"]')?.content || "";
      const button = page.querySelector("[data-place-order-btn]");
      button.disabled = true;
      button.textContent = "Đang xử lý...";

      try {
        const res = await fetch("/checkout/place-order", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
          },
          body: JSON.stringify(payload),
        });

        const data = await res.json();
        if (!res.ok) {
          throw new Error(data.message || "Không thể đặt hàng.");
        }

        localStorage.removeItem(CART_KEY);
        localStorage.removeItem(CART_META_KEY);
        refreshHeaderCartCount();
        window.AppToast?.success(`Đặt hàng thành công. Mã đơn: ${data.order_code}`);
        setTimeout(() => {
          window.location.href = "/products";
        }, 1200);
      } catch (error) {
        window.AppToast?.error(error.message || "Có lỗi khi đặt hàng.");
      } finally {
        button.disabled = false;
        button.textContent = "ĐẶT HÀNG";
      }
    });
  };

  document.addEventListener("DOMContentLoaded", () => {
    refreshHeaderCartCount();
    setupProductPurchase();
    setupCartPage();
    setupCheckoutPage();
  });
})();
