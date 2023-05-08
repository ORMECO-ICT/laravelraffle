import SoundEffects from './SoundEffects';
import Slot from './Slot';
import confetti from 'canvas-confetti';

// Initialize slot machine
(() => {
    const drawButton = document.getElementById('draw-button') as HTMLButtonElement | null;
    const fullscreenButton = document.getElementById('fullscreen-button') as HTMLButtonElement | null;
    const settingsButton = document.getElementById('settings-button') as HTMLButtonElement | null;
    const settingsWrapper = document.getElementById('settings') as HTMLDivElement | null;
    const settingsContent = document.getElementById('settings-panel') as HTMLDivElement | null;
    const settingsSaveButton = document.getElementById('settings-save') as HTMLButtonElement | null;
    const settingsCloseButton = document.getElementById('settings-close') as HTMLButtonElement | null;
    const sunburstSvg = document.getElementById('sunburst') as HTMLImageElement | null;
    const confettiCanvas = document.getElementById('confetti-canvas') as HTMLCanvasElement | null;
    const nameListTextArea = document.getElementById('name-list') as HTMLTextAreaElement | null;
    const removeNameFromListCheckbox = document.getElementById('remove-from-list') as HTMLInputElement | null;
    const enableSoundCheckbox = document.getElementById('enable-sound') as HTMLInputElement | null;

    const reelWinnerContainer = document.querySelector('.reel-winner') as HTMLElement;

    function toggleWinnerDetails(visible){
        if(!reelWinnerContainer) return;
      reelWinnerContainer.style.display = visible?'block':'none';
    }
    toggleWinnerDetails(false);

    // Graceful exit if necessary elements are not found
    if (!(
      drawButton
      && fullscreenButton
      && settingsButton
      && settingsWrapper
      && settingsContent
      && settingsSaveButton
      && settingsCloseButton
      && sunburstSvg
      && confettiCanvas
      && nameListTextArea
      && removeNameFromListCheckbox
      && enableSoundCheckbox
    )) {
      console.error('One or more Element ID is invalid. This is possibly a bug.');
      return;
    }

    if (!(confettiCanvas instanceof HTMLCanvasElement)) {
      console.error('Confetti canvas is not an instance of Canvas. This is possibly a bug.');
      return;
    }

    const soundEffects = new SoundEffects();
    const MAX_REEL_ITEMS = 40;
    const CONFETTI_COLORS = ['#26ccff', '#a25afd', '#ff5e7e', '#88ff5a', '#fcff42', '#ffa62d', '#ff36ff'];
    let confettiAnimationId;

    /** Confeetti animation instance */
    const customConfetti = confetti.create(confettiCanvas, {
      resize: true,
      useWorker: true
    });

    /** Triggers cconfeetti animation until animation is canceled */
    const confettiAnimation = () => {
      const windowWidth = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      const confettiScale = Math.max(0.5, Math.min(1, windowWidth / 1100));

      customConfetti({
        particleCount: 1,
        gravity: 0.8,
        spread: 90,
        origin: { y: 0.6 },
        colors: [CONFETTI_COLORS[Math.floor(Math.random() * CONFETTI_COLORS.length)]],
        scalar: confettiScale
      });

      confettiAnimationId = window.requestAnimationFrame(confettiAnimation);
    };

    /** Function to stop the winning animation */
    const stopWinningAnimation = () => {
      if (confettiAnimationId) {
        window.cancelAnimationFrame(confettiAnimationId);
      }
      sunburstSvg.style.display = 'none';
    };


    /**  Function to be trigger before spinning */
    const onSpinStart = () => {
      toggleWinnerDetails(false);
      stopWinningAnimation();
      drawButton.disabled = true;
      settingsButton.disabled = true;
      soundEffects.spin((MAX_REEL_ITEMS - 1) / 10);
    };

    /**  Functions to be trigger after spinning */
    const onSpinEnd = async () => {
      toggleWinnerDetails(true);
      confettiAnimation();
      sunburstSvg.style.display = 'block';
      await soundEffects.win();
      drawButton.disabled = false;
      settingsButton.disabled = false;
    };

    // const database = new Database();

    /** Slot instance */
    const slot = new Slot({
      reelContainerSelector: '#reel',
      maxReelItems: MAX_REEL_ITEMS,
      onSpinStart,
      onSpinEnd,
      onNameListChanged: stopWinningAnimation,
      reelWinnerNameContainerSelector: '#winner-name',
      reelWinnerAddressContainerSelector: '#winner-address'
    });

    /** To open the setting page */
    const onSettingsOpen = () => {
      nameListTextArea.value = slot.names.length ? slot.names.join('\n') : '';
      removeNameFromListCheckbox.checked = slot.shouldRemoveWinnerFromNameList;
      enableSoundCheckbox.checked = !soundEffects.mute;
      settingsWrapper.style.display = 'block';
    };

    /** To close the setting page */
    const onSettingsClose = () => {
      settingsContent.scrollTop = 0;
      settingsWrapper.style.display = 'none';
    };


    // ******************** START: LIVEWIRE HOOKS ***************************
    // // Click handler for "Draw" button
    // drawButton.addEventListener('click', () => {
    //   if (!slot.names.length) {
    //     onSettingsOpen();
    //     return;
    //   }

    //   slot.spin();
    // });

    window.addEventListener('onDraw', (e) => {
        console.log('onDraw');
        slot.names = e['detail'].entries;
        slot.winner = e['detail'].winner;
        console.log(slot.winner);

        if (!slot.names.length) {
            onSettingsOpen();
            return;
          }

          slot.spin();
    });
    // ******************** END: LIVEWIRE HOOKS ***************************


    // Hide fullscreen button when it is not supported
    // eslint-disable-next-line @typescript-eslint/ban-ts-comment
    // @ts-ignore - for older browsers support
    if (!(document.documentElement.requestFullscreen && document.exitFullscreen)) {
      fullscreenButton.remove();
    }

    // Click handler for "Fullscreen" button
    fullscreenButton.addEventListener('click', () => {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
        return;
      }

      if (document.exitFullscreen) {
        document.exitFullscreen();
      }
    });

    // Click handler for "Settings" button
    settingsButton.addEventListener('click', onSettingsOpen);

    // Click handler for "Save" button for setting page
    settingsSaveButton.addEventListener('click', () => {
      slot.names = nameListTextArea.value
        ? nameListTextArea.value.split(/\n/).filter((name) => Boolean(name.trim()))
        : [];
      slot.shouldRemoveWinnerFromNameList = removeNameFromListCheckbox.checked;
      soundEffects.mute = !enableSoundCheckbox.checked;
      onSettingsClose();
    });

    // Click handler for "Discard and close" button for setting page
    settingsCloseButton.addEventListener('click', onSettingsClose);



    // window.addEventListener('onWinner', (e) => {
    //     console.log(e);
    //     // $('#winner-name').html=e.detail.consumer_name;
    // });
  })();


