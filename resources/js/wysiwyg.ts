/**
 * TinyMCE on `textarea.wysiwyg`, with the same settings as
 * resources/views/partials/scripts/wysiwyg.blade.php, plus the text direction of
 * the textarea (or the page). Apps load TinyMCE themselves (`window.tinymce`);
 * without it the textareas stay plain. TinyMCE loaded after this script is picked
 * up on the window's `load` event.
 */
import { all, autoInit, isRtl, once } from "./dom"

export interface TinyMce {
  init: (settings: Record<string, unknown>) => unknown
}

declare global {
  interface Window {
    tinymce?: TinyMce
  }
}

/** The TinyMCE settings for a textarea. */
export function settingsFor(textarea: HTMLTextAreaElement): Record<string, unknown> {
  const rtl = isRtl(textarea)

  return {
    target: textarea,
    menubar: false,
    plugins: ["autolink", "link", "lists", "directionality", "code", "visualchars", "quickbars"],
    toolbar: [
      "undo redo | styles bold italic | bullist numlist | alignleft aligncenter alignright alignjustify alignnone |" +
        " link unlink | ltr rtl | outdent indent | code ",
    ],
    quickbars_insert_toolbar: false,
    directionality: rtl ? "rtl" : "ltr",
  }
}

export function init(root: ParentNode = document): void {
  const tinymce = window.tinymce
  if (!tinymce) return

  all<HTMLTextAreaElement>(root, "textarea.wysiwyg").forEach((textarea) => {
    if (once(textarea, "wysiwyg")) void tinymce.init(settingsFor(textarea))
  })
}

autoInit(init)

if (typeof document !== "undefined" && !document.documentElement.hasAttribute("data-forms-manual")) {
  window.addEventListener("load", () => init(document), { once: true })
}
