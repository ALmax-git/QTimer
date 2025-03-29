<div style="text-align: center !important; justify-items: center;">
  <style>
    .liquid_button {
      background-color: transparent;
      border: none;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      margin: auto;
    }

    .liquid_button svg {
      width: 0;
      height: 0;
    }

    .liquid_button p {
      width: 150px;
      height: 60px;
      z-index: 9;
      font-size: 20px;
      color: white;
      text-align: center;
      cursor: pointer;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      transition: all 0.3s ease;
      text-shadow: 0 0 10px rgb(34, 143, 147);
      letter-spacing: 1px;
      user-select: none;
    }

    .liquid_button p:hover+.liquid span:not(.bg) {
      animation-play-state: running;
    }

    .liquid_button p:hover {
      transform: scale(1.1);
    }

    .liquid_button:active p {
      transform: scale(1);
    }

    .liquid_button .liquid {
      filter: url(#gooey);
      width: 150px;
      height: 200px;
      position: absolute;
      inset: 0;
    }

    .liquid_button .liquid>span {
      position: absolute;
      top: 1px;
      left: -35px;
      width: 100%;
      height: 100%;
      display: block;
      animation: rotate 2.5s ease infinite;
      animation-delay: calc(0.15s * var(--i));
      animation-play-state: paused;
    }

    .liquid_button .liquid>span>span {
      animation: move 6s ease-in-out infinite;
      animation-delay: calc(0.2s * var(--i));
      background: rgb(77, 159, 170);
      width: 50px;
      height: 50px;
      display: block;
      margin: auto;
      border-radius: 50%;
    }

    .liquid_button .liquid span>span::before {
      content: "";
      position: absolute;
      left: calc(50% - 20px);
      top: 0;
      width: 40px;
      height: 40px;
      background: linear-gradient(#2b7cc8, #23d2db);
      border-radius: 50%;
      box-shadow: 0 0 30px hsl(0, 0%, 69%);
    }

    .liquid_button .liquid span.bg {
      animation: none;
    }

    .liquid_button .liquid span.bg>span::before {
      width: 150px;
      height: 50px;
      left: calc(50% - 40px);
      border-radius: 20px;
    }

    .liquid_button .liquid span:nth-child(2) {
      left: -20px;
    }

    .liquid_button .liquid span:nth-child(1) {
      left: -40px;
    }

    .liquid_button .liquid span:nth-child(3) {
      left: -50px;
    }

    .liquid_button .liquid span:nth-child(4) {
      left: 20px;
    }

    .liquid_button .liquid span:nth-child(7) {
      left: 40px;
    }

    .liquid_button .liquid span:nth-child(6) {
      left: 50px;
    }

    @keyframes rotate {
      0% {
        transform: rotate(0deg);
      }

      80%,
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes move {

      0%,
      100% {
        transform: translateX(0) translateY(0) scale(1);
      }

      20% {
        transform: translateX(-8px) translateY(-4px) scale(1.1);
      }

      40% {
        transform: translateX(8px) translateY(8px) scale(0.9);
      }

      60% {
        transform: translateX(-8px) translateY(4px) scale(1.1);
      }

      80% {
        transform: translateX(5px) translateY(-8px) scale(0.9);
      }
    }

    @media (pointer: coarse),
    (pointer: none) {
      .liquid_button .liquid>span>span {
        background: transparent;
      }
    }
  </style>
  <h1 style="text-align: center;">
    <button class="liquid_button" wire:click='logout'>
      <p>Thank you</p>
      <div class="liquid">
        <span style="--i:0"><span></span></span>
        <span style="--i:1"><span></span></span>
        <span style="--i:2"><span></span></span>
        <span style="--i:3"><span></span></span>
        <span style="--i:4"><span></span></span>
        <span style="--i:5"><span></span></span>
        <span style="--i:6"><span></span></span>
        <span class="bg"><span></span></span>
      </div>
      <svg>
        <filter id="gooey">
          <feGaussianBlur in="SourceGraphic" stdDeviation="10"></feGaussianBlur>
          <feColorMatrix values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"
            values="1 0 0 0 0
          0 1 0 0 0 
          0 0 1 0 0
          0 0 0 20 -10"></feColorMatrix>
        </filter>
      </svg>
    </button>
  </h1>
</div>
