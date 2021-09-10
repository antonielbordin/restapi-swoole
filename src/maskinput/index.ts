import { registerElement, registerNativeConfigElement,  NativeElementNode } from 'svelte-native/dom'
import { NativeViewElementNode, NativeElementPropType as PropType } from "svelte-native/dom";
import { TextField } from "nativescript-ui-textfield";
import { View } from "@nativescript/core";


class BaseMaskField<T extends View> extends NativeViewElementNode<T> {
   constructor(tagName: string, viewClass: new () => T) {
      super(tagName, viewClass, null);
   }
}

export default class MaskTextField {
   static register() {
      const registerConfigElement = (tag: string, native: new () => any, parentProp: string = null) => 
      registerNativeConfigElement(tag, () => native, parentProp)



   }
}

