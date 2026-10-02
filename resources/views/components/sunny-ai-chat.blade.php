@props([
    'position' => 'bottom-right',
    'title' => 'Sunny AI',
    'placeholder' => "Ask Sunny AI or type '/' for commands..."
])

<!-- SUNNY AI BACKDROP OVERLAY -->
<div id="sunnyAiBackdrop" class="sunny-ai-backdrop d-none"></div>

<!-- SUNNY AI FLOATING WIDGET COMPONENT -->
<div id="sunnyAiWidgetContainer" class="sunny-ai-wrapper" style="z-index: 9998; margin-right: 35px;">
    <!-- Floating Trigger Pill / Button -->
    <button type="button" id="sunnyAiTriggerBtn" class="sunny-ai-pill-btn shadow-lg" title="Open Sunny AI Assistant">
        <span class="sunny-ai-pill-glow"></span>
        <span class="sunny-ai-pill-icon">
            <i class="ri-sparkling-2-fill"></i>
        </span>
        <span class="sunny-ai-pill-text">{{ $title }}</span>
        <span class="badge bg-white text-primary rounded-pill fs-10 px-1 py-0 ms-1 fw-bold">PRO</span>
    </button>

    <!-- Floating Chat / Prompting Window -->
    <div id="sunnyAiChatWindow" class="sunny-ai-card shadow-2xl d-none">
        <!-- Header -->
        <div class="sunny-ai-header d-flex align-items-center justify-content-between p-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div class="sunny-ai-avatar">
                    <i class="ri-sparkling-2-fill"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="fw-bold fs-14 text-dark">{{ $title }}</span>
                        <span class="badge bg-success-transparent text-success fs-10 px-1 py-0">Online</span>
                    </div>
                    <span class="text-muted fs-11">CDP Intelligence Assistant</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle" id="sunnyAiClearBtn" title="Clear chat">
                    <i class="ri-refresh-line fs-14"></i>
                </button>
                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary rounded-circle" id="sunnyAiCloseBtn" title="Minimize">
                    <i class="ri-close-line fs-18"></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div id="sunnyAiMessages" class="sunny-ai-body p-3">
            <!-- Welcome Bot Message -->
            <div class="sunny-ai-msg sunny-ai-msg-bot d-flex gap-2 mb-3">
                <div class="sunny-ai-msg-avatar">
                    <i class="ri-sparkling-fill"></i>
                </div>
                <div class="sunny-ai-msg-bubble">
                    <p class="mb-1 fs-12 fw-medium text-dark">Halo! Saya <strong>Sunny AI</strong>.</p>
                    <p class="mb-2 fs-12 text-muted">Saya siap membantu menganalisis kontak, segmentasi kampanye, atau membuat laporan CDP. Coba ketik <code class="text-primary fw-bold">/</code> untuk melihat perintah cepat:</p>
                    <div class="d-flex flex-wrap gap-1">
                        <button type="button" class="badge bg-light text-dark border quick-slash-btn" data-cmd="/search">/search</button>
                        <button type="button" class="badge bg-light text-dark border quick-slash-btn" data-cmd="/report">/report</button>
                        <button type="button" class="badge bg-light text-dark border quick-slash-btn" data-cmd="/summary">/summary</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slash Command Autocomplete Menu -->
        <div id="sunnyAiSlashMenu" class="sunny-ai-slash-menu shadow-lg d-none">
            <div class="slash-menu-header px-3 py-1 bg-light text-muted fs-11 fw-semibold border-bottom">
                COMMANDS
            </div>
            <div class="slash-item active" data-command="/search">
                <div class="slash-icon bg-primary-transparent text-primary"><i class="ri-search-eye-line"></i></div>
                <div class="slash-info">
                    <div class="slash-title">/search</div>
                    <div class="slash-desc">Cari cepat kontak & profil subscriber Telco</div>
                </div>
            </div>
            <div class="slash-item" data-command="/report">
                <div class="slash-icon bg-success-transparent text-success"><i class="ri-file-chart-line"></i></div>
                <div class="slash-info">
                    <div class="slash-title">/report</div>
                    <div class="slash-desc">Buat laporan analitik CDP & performa kampanye</div>
                </div>
            </div>
            <div class="slash-item" data-command="/summary">
                <div class="slash-icon bg-warning-transparent text-warning"><i class="ri-pie-chart-line"></i></div>
                <div class="slash-info">
                    <div class="slash-title">/summary</div>
                    <div class="slash-desc">Ringkas insight demografi, credit score & spending</div>
                </div>
            </div>
        </div>

        <!-- Input Box Area -->
        <div class="sunny-ai-footer p-2 border-top bg-white">
            <form id="sunnyAiForm" class="d-flex align-items-center gap-1 position-relative w-100">
                <div class="sunny-ai-input-pill d-flex align-items-center gap-1 w-100 rounded-pill px-3 py-1 bg-white border border-primary-subtle position-relative shadow-sm">
                    <!-- Command Pill Badge inside Input -->
                    <div id="sunnyAiCommandBadge" class="d-none align-items-center gap-1 badge bg-primary text-white py-1 px-2 rounded-pill fs-11 flex-shrink-0">
                        <i id="sunnyAiBadgeIcon" class="ri-command-line"></i>
                        <span id="sunnyAiBadgeText">/search</span>
                        <button type="button" id="sunnyAiRemoveBadge" class="btn-close btn-close-white ms-1 p-0" style="font-size: 8px; line-height: 1;" title="Hapus perintah"></button>
                    </div>
                    <input type="text" id="sunnyAiInput" class="form-control border-0 p-0 fs-12 flex-grow-1 shadow-none bg-transparent" placeholder="{{ $placeholder }}" autocomplete="off">
                    <button class="btn btn-primary rounded-circle btn-send-prompt flex-shrink-0" type="submit" id="sunnyAiSendBtn" style="width: 28px; height: 28px; padding: 0;">
                        <i class="ri-send-plane-fill fs-12"></i>
                    </button>
                </div>
            </form>
            <div class="d-flex align-items-center justify-content-between px-2 pt-1 text-muted fs-10">
                <span>Tips: Ketik <kbd>/</kbd> untuk menu perintah</span>
                <span>Powered by Sunny CDP</span>
            </div>
        </div>
    </div>
</div>

<style>
/* Sunny AI Backdrop Dimming Overlay */
.sunny-ai-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    z-index: 1049;
    opacity: 0;
    pointer-events: none !important;
    display: none !important;
    transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    cursor: pointer;
}
.sunny-ai-backdrop.active {
    display: block !important;
    opacity: 1 !important;
    pointer-events: auto !important;
}

/* Sunny AI Widget Styles */
.sunny-ai-wrapper {
    position: fixed;
    bottom: 24px;
    right: 28px;
    z-index: 1050;
    font-family: inherit;
}

/* Trigger Pill Button */
.sunny-ai-pill-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #ff7a00 0%, #ff5500 50%, #e64a19 100%);
    color: #ffffff;
    border: none;
    padding: 10px 18px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(255, 102, 0, 0.35);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.sunny-ai-pill-btn:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 30px rgba(255, 102, 0, 0.45);
}

.sunny-ai-pill-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    animation: sunnyAiSparkle 2s ease-in-out infinite;
}

@keyframes sunnyAiSparkle {
    0%, 100% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(15deg) scale(1.15); }
}

/* Chat Card Window - TALLER & FOCUSED */
.sunny-ai-card {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 440px;
    max-width: calc(100vw - 32px);
    height: 680px;
    max-height: calc(100vh - 48px);
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: sunnyAiSlideUp 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 1051;
}

@keyframes sunnyAiSlideUp {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.sunny-ai-header {
    background: #ffffff;
}

.sunny-ai-avatar {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ff7a00, #ff5500);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

/* Chat Body */
.sunny-ai-body {
    flex: 1;
    overflow-y: auto;
    background: #f8fafc;
    scroll-behavior: smooth;
}

.sunny-ai-msg-avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff7a00, #ff5500);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.sunny-ai-msg-bubble {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 12px;
    max-width: 85%;
    font-size: 12px;
    line-height: 1.45;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.sunny-ai-msg-user {
    justify-content: flex-end;
}

.sunny-ai-msg-user .sunny-ai-msg-bubble {
    background: #ff7a00;
    color: #ffffff;
    border: none;
    border-top-right-radius: 4px;
}

.sunny-ai-msg-user .sunny-ai-msg-bubble p {
    color: #ffffff !important;
}

/* Slash Menu Autocomplete */
.sunny-ai-slash-menu {
    position: absolute;
    bottom: 64px;
    left: 12px;
    right: 12px;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    z-index: 20;
}

.slash-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    cursor: pointer;
    transition: background 0.15s ease;
}

.slash-item:hover, .slash-item.active {
    background: #f1f5f9;
}

.slash-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.slash-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
}

.slash-desc {
    font-size: 11px;
    color: #64748b;
}

.quick-slash-btn {
    cursor: pointer;
    transition: all 0.15s ease;
}

.quick-slash-btn:hover {
    background: #e2e8f0 !important;
    transform: translateY(-1px);
}

/* Interactive Input Pill Container & Command Badge */
.sunny-ai-input-pill {
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    min-height: 42px;
}
.sunny-ai-input-pill:focus-within {
    border-color: #ff7a00 !important;
    box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.15) !important;
}
#sunnyAiCommandBadge {
    background: linear-gradient(135deg, #ff7a00, #ff5500) !important;
    animation: badgePop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 2px 6px rgba(255, 102, 0, 0.25);
    white-space: nowrap;
}
@keyframes badgePop {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const triggerBtn = document.getElementById('sunnyAiTriggerBtn');
        const chatWindow = document.getElementById('sunnyAiChatWindow');
        const backdropEl = document.getElementById('sunnyAiBackdrop');
        const closeBtn = document.getElementById('sunnyAiCloseBtn');
        const clearBtn = document.getElementById('sunnyAiClearBtn');
        const inputEl = document.getElementById('sunnyAiInput');
        const formEl = document.getElementById('sunnyAiForm');
        const messagesEl = document.getElementById('sunnyAiMessages');
        const slashMenu = document.getElementById('sunnyAiSlashMenu');

        if (!triggerBtn || !chatWindow) return;

        // Function to automatically close any other active modals, offcanvases, or popups
        function closeOtherPopups() {
            // Close active Bootstrap Modals
            document.querySelectorAll('.modal.show').forEach(function(modalEl) {
                try {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const inst = bootstrap.Modal.getInstance(modalEl);
                        if (inst) inst.hide();
                    }
                } catch (e) {}
            });

            // Close active Bootstrap Offcanvases (e.g. detail drawer)
            document.querySelectorAll('.offcanvas.show').forEach(function(offcanvasEl) {
                try {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
                        const inst = bootstrap.Offcanvas.getInstance(offcanvasEl);
                        if (inst) inst.hide();
                    }
                } catch (e) {}
            });

            // Close open dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(function(dd) {
                dd.classList.remove('show');
            });
        }

        // Open Sunny AI and Dim Background
        function openSunnyAi() {
            closeOtherPopups();
            if (backdropEl) {
                backdropEl.classList.remove('d-none');
                backdropEl.style.display = 'block';
                backdropEl.style.pointerEvents = 'auto';
                requestAnimationFrame(() => backdropEl.classList.add('active'));
            }
            chatWindow.classList.remove('d-none');
            triggerBtn.classList.add('d-none');
            setTimeout(() => inputEl.focus(), 150);
        }

        // Close Sunny AI and Restore Background
        function closeSunnyAi() {
            chatWindow.classList.add('d-none');
            triggerBtn.classList.remove('d-none');
            hideSlashMenu();
            if (backdropEl) {
                backdropEl.classList.remove('active');
                backdropEl.classList.add('d-none');
                backdropEl.style.display = 'none';
                backdropEl.style.pointerEvents = 'none';
            }
            // Ensure no lingering backdrop or scroll locking prevents clicks on the page
            document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.body.style.pointerEvents = '';
        }

        // Toggle Chat Window
        triggerBtn.addEventListener('click', openSunnyAi);
        closeBtn.addEventListener('click', closeSunnyAi);
        if (backdropEl) {
            backdropEl.addEventListener('click', closeSunnyAi);
        }

        // Close on Escape key if slash menu is already closed
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !chatWindow.classList.contains('d-none') && slashMenu.classList.contains('d-none')) {
                closeSunnyAi();
            }
        });

        // Command Badge State Management
        let currentSelectedCommand = null;
        const commandBadge = document.getElementById('sunnyAiCommandBadge');
        const badgeText = document.getElementById('sunnyAiBadgeText');
        const badgeIcon = document.getElementById('sunnyAiBadgeIcon');
        const removeBadgeBtn = document.getElementById('sunnyAiRemoveBadge');
        const defaultPlaceholder = "{{ $placeholder }}";

        function getCmdIcon(cmd) {
            if (!cmd) return 'ri-command-line';
            if (cmd.startsWith('/search')) return 'ri-search-eye-line';
            if (cmd.startsWith('/report')) return 'ri-file-chart-line';
            if (cmd.startsWith('/summary')) return 'ri-pie-chart-line';
            return 'ri-command-line';
        }

        function setCommandBadge(cmd) {
            currentSelectedCommand = cmd;
            badgeText.innerText = cmd;
            badgeIcon.className = getCmdIcon(cmd);
            commandBadge.classList.remove('d-none');
            commandBadge.classList.add('d-flex');
            inputEl.value = '';
            
            if (cmd === '/search') {
                inputEl.placeholder = 'Ketik nama / nomor kontak yang ingin dicari...';
            } else if (cmd === '/report') {
                inputEl.placeholder = 'Ketik topik laporan atau performa kampanye...';
            } else if (cmd === '/summary') {
                inputEl.placeholder = 'Ketik parameter ringkasan atau insight...';
            }
            
            hideSlashMenu();
            inputEl.focus();
        }

        function removeCommandBadge() {
            currentSelectedCommand = null;
            commandBadge.classList.add('d-none');
            commandBadge.classList.remove('d-flex');
            inputEl.placeholder = defaultPlaceholder;
            inputEl.focus();
        }

        if (removeBadgeBtn) {
            removeBadgeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeCommandBadge();
            });
        }

        clearBtn.addEventListener('click', function() {
            removeCommandBadge();
            messagesEl.innerHTML = `
                <div class="sunny-ai-msg sunny-ai-msg-bot d-flex gap-2 mb-3">
                    <div class="sunny-ai-msg-avatar"><i class="ri-sparkling-fill"></i></div>
                    <div class="sunny-ai-msg-bubble">
                        <p class="mb-1 fs-12 fw-medium text-dark">Obrolan di-reset.</p>
                        <p class="mb-2 fs-12 text-muted">Ada yang bisa saya bantu terkait data CDP & Kontak?</p>
                        <div class="d-flex flex-wrap gap-1">
                            <button type="button" class="badge bg-light text-dark border quick-slash-btn" data-cmd="/search">/search</button>
                            <button type="button" class="badge bg-light text-dark border quick-slash-btn" data-cmd="/report">/report</button>
                            <button type="button" class="badge bg-light text-dark border quick-slash-btn" data-cmd="/summary">/summary</button>
                        </div>
                    </div>
                </div>
            `;
            attachQuickSlashEvents();
        });

        // Slash Autocomplete Handling
        inputEl.addEventListener('input', function() {
            const val = this.value;
            // If user types slash command with space directly, convert to badge
            if (!currentSelectedCommand) {
                if (val === '/search ' || val === '/report ' || val === '/summary ') {
                    setCommandBadge(val.trim());
                    return;
                }
            }

            if (val.startsWith('/') && !currentSelectedCommand) {
                showSlashMenu(val.slice(1).toLowerCase());
            } else {
                hideSlashMenu();
            }
        });

        inputEl.addEventListener('keydown', function(e) {
            // Remove badge on backspace when input is empty
            if (e.key === 'Backspace' && inputEl.value === '' && currentSelectedCommand) {
                e.preventDefault();
                removeCommandBadge();
                return;
            }

            if (!slashMenu.classList.contains('d-none')) {
                const items = slashMenu.querySelectorAll('.slash-item');
                let activeIdx = -1;
                items.forEach((it, idx) => {
                    if (it.classList.contains('active')) activeIdx = idx;
                });

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (activeIdx < items.length - 1) setActiveItem(items, activeIdx + 1);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (activeIdx > 0) setActiveItem(items, activeIdx - 1);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (activeIdx >= 0 && items[activeIdx]) {
                        selectSlashItem(items[activeIdx].dataset.command);
                    }
                } else if (e.key === 'Escape') {
                    hideSlashMenu();
                }
            }
        });

        function setActiveItem(items, idx) {
            items.forEach(it => it.classList.remove('active'));
            if (items[idx]) items[idx].classList.add('active');
        }

        function showSlashMenu(filterText) {
            const items = slashMenu.querySelectorAll('.slash-item');
            let hasVisible = false;
            items.forEach(it => {
                const cmd = it.dataset.command.toLowerCase();
                if (!filterText || cmd.includes(filterText)) {
                    it.style.display = 'flex';
                    hasVisible = true;
                } else {
                    it.style.display = 'none';
                }
            });

            if (hasVisible) {
                slashMenu.classList.remove('d-none');
                const firstVisible = Array.from(items).find(it => it.style.display !== 'none');
                if (firstVisible) {
                    items.forEach(it => it.classList.remove('active'));
                    firstVisible.classList.add('active');
                }
            } else {
                hideSlashMenu();
            }
        }

        function hideSlashMenu() {
            slashMenu.classList.add('d-none');
        }

        function selectSlashItem(cmd) {
            setCommandBadge(cmd);
        }

        // Clicking on Slash Items
        slashMenu.querySelectorAll('.slash-item').forEach(it => {
            it.addEventListener('click', function() {
                selectSlashItem(this.dataset.command);
            });
        });

        // Quick Slash Buttons in chat bubbles
        function attachQuickSlashEvents() {
            document.querySelectorAll('.quick-slash-btn').forEach(btn => {
                btn.onclick = function() {
                    const cmd = this.dataset.cmd;
                    selectSlashItem(cmd);
                };
            });
        }
        attachQuickSlashEvents();

        // Form Submit
        formEl.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = inputEl.value.trim();
            const activeCmd = currentSelectedCommand;

            if (!text && !activeCmd) return;

            hideSlashMenu();
            appendUserMessage(activeCmd, text);

            const promptToSend = activeCmd ? `${activeCmd} ${text}`.trim() : text;
            inputEl.value = '';
            removeCommandBadge();

            // Simulate AI Processing & Response
            showBotTyping();
            setTimeout(() => {
                removeBotTyping();
                generateAiResponse(promptToSend);
            }, 1200);
        });

        function appendUserMessage(cmd, text) {
            const div = document.createElement('div');
            div.className = 'sunny-ai-msg sunny-ai-msg-user d-flex mb-3';
            let contentHtml = '';
            if (cmd) {
                contentHtml = `
                    <div class="d-flex align-items-center flex-wrap gap-1">
                        <span class="badge bg-white text-primary border border-white fw-bold py-1 px-2 rounded-pill shadow-xs">
                            <i class="${getCmdIcon(cmd)} me-1"></i>${cmd}
                        </span>
                        <span class="align-middle">${escapeHtml(text || 'Jalankan analisis')}</span>
                    </div>
                `;
            } else {
                contentHtml = `<span class="align-middle">${escapeHtml(text)}</span>`;
            }

            div.innerHTML = `
                <div class="sunny-ai-msg-bubble">
                    ${contentHtml}
                </div>
            `;
            messagesEl.appendChild(div);
            scrollToBottom();
        }

        function showBotTyping() {
            const div = document.createElement('div');
            div.id = 'sunnyAiTyping';
            div.className = 'sunny-ai-msg sunny-ai-msg-bot d-flex gap-2 mb-3';
            div.innerHTML = `
                <div class="sunny-ai-msg-avatar"><i class="ri-sparkling-fill"></i></div>
                <div class="sunny-ai-msg-bubble bg-light">
                    <div class="d-flex align-items-center gap-1 text-muted fs-11">
                        <span class="spinner-border spinner-border-sm text-primary" style="width: 12px; height: 12px;"></span>
                        <span>Sunny AI sedang menganalisis...</span>
                    </div>
                </div>
            `;
            messagesEl.appendChild(div);
            scrollToBottom();
        }

        function removeBotTyping() {
            const typing = document.getElementById('sunnyAiTyping');
            if (typing) typing.remove();
        }

        function generateAiResponse(prompt) {
            const p = prompt.toLowerCase();
            let botReply = '';

            if (p.startsWith('/search')) {
                const query = prompt.replace(/\/search/i, '').trim();
                botReply = `
                    <p class="mb-1 fw-bold text-primary"><i class="ri-search-eye-line me-1"></i>Hasil Pencarian Kontak CDP</p>
                    <p class="mb-2 fs-11 text-muted">Mencari query: <em>"${query || 'Semua Kontak Enriched'}"</em></p>
                    <div class="p-2 bg-light rounded border mb-2 fs-11">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>18 Kontak Enriched</strong>
                            <span class="badge bg-success-transparent text-success">Verified</span>
                        </div>
                        <div class="text-muted">&bull; 12 Subscriber Telkomsel & XL Prioritas</div>
                        <div class="text-muted">&bull; 6 Subscriber Indosat Prime & IM3 Platinum</div>
                        <div class="text-muted">&bull; 1 Manual Contact (Unverified)</div>
                    </div>
                    <span class="text-muted fs-11">Gunakan filter <strong>CDP Enriched</strong> di tabel untuk melihat daftar lengkap.</span>
                `;
            } else if (p.startsWith('/report')) {
                const isMarathon = p.includes('marathon');
                
                if (isMarathon) {
                    botReply = `
                        <div class="d-flex align-items-center gap-1 mb-1 text-primary fw-bold fs-13">
                            <i class="ri-file-chart-line"></i>
                            <span>Marathon Participant Insights</span>
                        </div>
                        <p class="mb-2 text-muted fs-11">Laporan komprehensif karakteristik & perilaku 5.824 peserta marathon terverifikasi (Jan–Mar 2026):</p>
                        
                        <div class="table-responsive my-2">
                            <table class="table table-sm table-bordered fs-11 mb-1 bg-white">
                                <thead class="table-light">
                                    <tr><th>Parameter</th><th>Temuan Kunci</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>Total Peserta</td><td><strong>5.824 Peserta</strong> (100% Verified)</td></tr>
                                    <tr><td>Demografi Usia</td><td>36% (25-34 thn) &bull; 28% (35-44 thn)</td></tr>
                                    <tr><td>Kategori Sosial</td><td>54% Middle Class &bull; 18% High Class</td></tr>
                                    <tr><td>Produk Terpopuler</td><td>Kesehatan & Kebugaran (72%), Isotonik (58%)</td></tr>
                                    <tr><td>Aplikasi Terbanyak</td><td>Aplikasi Lari/Fitness (68%), Media Sosial (62%)</td></tr>
                                    <tr><td>Metode Bayar</td><td>E-Wallet (57%) &bull; Perlengkapan Lari (38%)</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Single Click Auto Download Card -->
                        <div class="p-2 rounded-3 border border-primary border-opacity-25 bg-primary-transparent my-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2 overflow-hidden">
                                    <div class="p-2 bg-danger-transparent text-danger rounded-2 fs-18 flex-shrink-0">
                                        <i class="ri-file-pdf-2-fill"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fw-bold fs-11 text-dark text-truncate" title="Marathon Participant Insights.pdf">Marathon Participant Insights.pdf</div>
                                        <div class="text-muted fs-10">264 KB &bull; Siap di-download</div>
                                    </div>
                                </div>
                                <a href="{{ asset('Marathon Participant Insights.pdf') }}" download="Marathon Participant Insights.pdf" class="btn btn-sm btn-primary rounded-pill d-flex align-items-center gap-1 px-3 py-1 flex-shrink-0 text-white fw-medium shadow-sm">
                                    <i class="ri-download-2-line"></i>
                                    <span>Download PDF</span>
                                </a>
                            </div>
                        </div>

                        <div class="fs-10 text-muted mt-1">
                            <i class="ri-information-line me-1"></i>Klik tombol Download untuk mengunduh laporan PDF lengkap secara langsung.
                        </div>
                    `;
                } else {
                    botReply = `
                        <div class="d-flex align-items-center gap-1 mb-1 text-success fw-bold fs-13">
                            <i class="ri-file-chart-line"></i>
                            <span>Executive Talent & Profile Insights</span>
                        </div>
                        <p class="mb-2 text-muted fs-11">Analisis profil profesional level Manager ke atas di wilayah Jakarta (Usia 30-50 thn, Terverifikasi Clean Record & Good Credit Score):</p>
                        
                        <div class="table-responsive my-2">
                            <table class="table table-sm table-bordered fs-11 mb-1 bg-white">
                                <thead class="table-light">
                                    <tr><th>Metrik Screening</th><th>Hasil Validasi</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>Total Database</td><td><strong>4.850 Kandidat</strong> (100% Screened)</td></tr>
                                    <tr><td>Sebaran Domisili</td><td>Jakarta Selatan 40% &bull; Jakpus 30% &bull; Jakbar 15%</td></tr>
                                    <tr><td>Kepatuhan Hukum</td><td><strong>100% Bebas Blacklist & No Gambling</strong></td></tr>
                                    <tr><td>Credit Health Score</td><td><strong>Grade A+</strong> (70% Kol 1 Lancar, 22% Excellent)</td></tr>
                                    <tr><td>Sektor Industri</td><td>Perbankan/Fintech 35%, IT & Telco 25%, FMCG 18%</td></tr>
                                    <tr><td>Level Jabatan</td><td>Middle Mgr 52%, Senior Mgr 28%, C-Level 7%</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Single Click Auto Download Card -->
                        <div class="p-2 rounded-3 border border-success border-opacity-25 bg-success-transparent my-2">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2 overflow-hidden">
                                    <div class="p-2 bg-danger-transparent text-danger rounded-2 fs-18 flex-shrink-0">
                                        <i class="ri-file-pdf-2-fill"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fw-bold fs-11 text-dark text-truncate" title="Executive Talent & Profile Insights.pdf">Executive Talent & Profile Insights.pdf</div>
                                        <div class="text-muted fs-10">290 KB &bull; Siap di-download</div>
                                    </div>
                                </div>
                                <a href="{{ asset('Executive Talent & Profile Insights.pdf') }}" download="Executive Talent & Profile Insights.pdf" class="btn btn-sm btn-success rounded-pill d-flex align-items-center gap-1 px-3 py-1 flex-shrink-0 text-white fw-medium shadow-sm">
                                    <i class="ri-download-2-line"></i>
                                    <span>Download PDF</span>
                                </a>
                            </div>
                        </div>

                        <div class="fs-10 text-muted mt-1">
                            <i class="ri-information-line me-1"></i>Klik tombol Download untuk mengunduh laporan PDF lengkap secara langsung.
                        </div>
                    `;
                }
            } else if (p.startsWith('/summary')) {
                botReply = `
                    <p class="mb-1 fw-bold text-warning"><i class="ri-pie-chart-line me-1"></i>Summary Insight Kontak</p>
                    <p class="mb-1 fs-12">Berdasarkan profil yang telah di-enrich:</p>
                    <ul class="ps-3 mb-2 fs-11 text-muted">
                        <li><strong>Domisili Terbanyak:</strong> Jakarta Selatan & Jakarta Pusat (Kawasan High Class).</li>
                        <li><strong>Mayoritas Perangkat:</strong> iPhone 15 Pro Max & Samsung S24 Ultra.</li>
                        <li><strong>Eligibilitas Finansial:</strong> 100% bebas indikasi gambling dan riwayat pembayaran lancar.</li>
                    </ul>
                    <div class="p-1 px-2 bg-light rounded text-dark fs-11 border">
                        <i class="ri-lightbulb-line text-warning me-1"></i>Rekomendasi: Cocok untuk penawaran produk segmen Premium/Prioritas.
                    </div>
                `;
            } else {
                botReply = `
                    <p class="mb-1">Terima kasih atas pertanyaannya! Terkait <em>"${escapeHtml(prompt)}"</em>:</p>
                    <p class="mb-2 text-muted fs-11">Data Kontak pada Sunny CDP saat ini memuat 19 kontak (18 berhasil di-enrich via Telco Gateway, 1 manual).</p>
                    <p class="mb-0 text-muted fs-11">Ketik <code class="text-primary">/</code> untuk opsi cepat: <code>/search</code>, <code>/report</code>, atau <code>/summary</code>.</p>
                `;
            }

            const div = document.createElement('div');
            div.className = 'sunny-ai-msg sunny-ai-msg-bot d-flex gap-2 mb-3';
            div.innerHTML = `
                <div class="sunny-ai-msg-avatar"><i class="ri-sparkling-fill"></i></div>
                <div class="sunny-ai-msg-bubble">
                    ${botReply}
                </div>
            `;
            messagesEl.appendChild(div);
            attachQuickSlashEvents();
            scrollToBottom();
        }

        function scrollToBottom() {
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    });
})();
</script>
