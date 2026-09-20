const registerPwa = async () => {
    if (!('serviceWorker' in navigator)) return null;
    const registration = await navigator.serviceWorker.register('/sw.js', {scope: '/'});
    registration.update().catch(() => {});

    let deferredPrompt = null;
    window.addEventListener('beforeinstallprompt', event => {
        event.preventDefault();
        deferredPrompt = event;
        window.dispatchEvent(new CustomEvent('pwa-install-available'));
    });
    window.addEventListener('pwa-install-request', async () => {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        await deferredPrompt.userChoice;
        deferredPrompt = null;
    });
    return registration;
};
registerPwa().catch(error => console.error('PWA registration failed', error));
