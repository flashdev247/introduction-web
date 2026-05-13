(function () {
  const colors = {
    success: "#2f855a",
    error: "#c53030",
    info: "#8b6f47",
  };

  const ensureFallbackRoot = () => {
    let root = document.querySelector("[data-app-toast-root]");
    if (root) return root;

    root = document.createElement("div");
    root.dataset.appToastRoot = "true";
    root.style.position = "fixed";
    root.style.top = "18px";
    root.style.right = "18px";
    root.style.zIndex = "9999";
    root.style.display = "grid";
    root.style.gap = "10px";
    root.style.maxWidth = "min(360px, calc(100vw - 32px))";
    document.body.appendChild(root);
    return root;
  };

  const fallbackToast = (message, type) => {
    const root = ensureFallbackRoot();
    const toast = document.createElement("div");
    toast.textContent = message;
    toast.style.background = colors[type] || colors.info;
    toast.style.color = "#fff";
    toast.style.padding = "12px 14px";
    toast.style.borderRadius = "8px";
    toast.style.boxShadow = "0 14px 28px rgba(0,0,0,.18)";
    toast.style.fontSize = "14px";
    toast.style.lineHeight = "1.45";
    root.appendChild(toast);
    setTimeout(() => toast.remove(), 3600);
  };

  const showToast = (message, type) => {
    if (window.Toastify) {
      window.Toastify({
        text: message,
        duration: 3600,
        gravity: "top",
        position: window.matchMedia("(max-width: 640px)").matches ? "center" : "right",
        stopOnFocus: true,
        close: true,
        style: {
          background: colors[type] || colors.info,
          borderRadius: "8px",
          boxShadow: "0 14px 28px rgba(0,0,0,.18)",
          fontSize: "14px",
          lineHeight: "1.45",
        },
      }).showToast();
      return;
    }

    fallbackToast(message, type);
  };

  const ensureConfirmModal = () => {
    let modal = document.querySelector("[data-app-confirm-modal]");
    if (modal) return modal;

    modal = document.createElement("div");
    modal.dataset.appConfirmModal = "true";
    modal.style.position = "fixed";
    modal.style.inset = "0";
    modal.style.zIndex = "10000";
    modal.style.display = "none";
    modal.style.alignItems = "center";
    modal.style.justifyContent = "center";
    modal.style.background = "rgba(17, 17, 17, .46)";
    modal.style.padding = "18px";
    modal.innerHTML = `
      <div style="width:min(420px,100%);background:#fff;border-radius:10px;border:1px solid #e6e0d6;box-shadow:0 22px 44px rgba(0,0,0,.2);padding:22px;">
        <h3 style="margin:0 0 8px;font-size:20px;line-height:1.25;color:#1f1f1f;">Xác nhận thao tác</h3>
        <p data-app-confirm-message style="margin:0;color:#555;line-height:1.55;"></p>
        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:22px;">
          <button type="button" data-app-confirm-cancel style="border:1px solid #e6e0d6;background:#fff;color:#1f1f1f;padding:10px 14px;border-radius:6px;cursor:pointer;">Hủy</button>
          <button type="button" data-app-confirm-ok style="border:1px solid #8b6f47;background:#8b6f47;color:#fff;padding:10px 14px;border-radius:6px;cursor:pointer;">Xác nhận</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
    return modal;
  };

  const confirm = ({ message, onConfirm }) => {
    const modal = ensureConfirmModal();
    const msg = modal.querySelector("[data-app-confirm-message]");
    const cancel = modal.querySelector("[data-app-confirm-cancel]");
    const ok = modal.querySelector("[data-app-confirm-ok]");

    msg.textContent = message || "Bạn có chắc muốn thực hiện thao tác này?";
    modal.style.display = "flex";

    const cleanup = () => {
      modal.style.display = "none";
      cancel.removeEventListener("click", handleCancel);
      ok.removeEventListener("click", handleOk);
      modal.removeEventListener("click", handleBackdrop);
      document.removeEventListener("keydown", handleEscape);
    };

    const handleCancel = () => cleanup();
    const handleOk = () => {
      cleanup();
      if (typeof onConfirm === "function") onConfirm();
    };
    const handleBackdrop = (event) => {
      if (event.target === modal) cleanup();
    };
    const handleEscape = (event) => {
      if (event.key === "Escape") cleanup();
    };

    cancel.addEventListener("click", handleCancel);
    ok.addEventListener("click", handleOk);
    modal.addEventListener("click", handleBackdrop);
    document.addEventListener("keydown", handleEscape);
  };

  window.AppToast = {
    success: (message) => showToast(message, "success"),
    error: (message) => showToast(message, "error"),
    info: (message) => showToast(message, "info"),
    confirm,
  };

  document.addEventListener("submit", function (event) {
    const trigger = event.submitter;
    if (trigger?.dataset?.confirmed === "true") {
      delete trigger.dataset.confirmed;
      return;
    }

    const message = trigger?.dataset?.confirmMessage;
    if (!message) return;

    event.preventDefault();
    const form = event.target;
    confirm({
      message,
      onConfirm: () => {
        trigger.dataset.confirmed = "true";
        form.requestSubmit(trigger);
      },
    });
  }, true);
})();
