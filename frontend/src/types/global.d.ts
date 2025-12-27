interface NetlifyIdentity {
  on: (event: string, callback: (user?: any) => void) => void;
  open: (tab?: string) => void;
  close: () => void;
  init: () => void;
  currentUser: () => any;
}

declare global {
  interface Window {
    netlifyIdentity?: NetlifyIdentity;
  }
}

export {};
