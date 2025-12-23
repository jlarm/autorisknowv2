<div x-data>
    <form x-show="!$wire.submitted" wire:submit="submit" onsubmit="fathom.trackEvent('form submit')" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div><label class="block text-sm text-slate-400 font-medium mb-2">Name*</label><input wire:model.blur="name"
                    required
                    class="w-full bg-[#1e293b] border border-white/10 rounded-lg p-3 text-white focus:border-[#036482] focus:ring-1 focus:ring-[#036482] outline-none transition-all placeholder-slate-600"
                    placeholder="Your Name" type="text" value="">
                <flux:error name="name" />
            </div>
            <div><label class="block text-sm text-slate-400 font-medium mb-2">Email*</label><input
                    wire:model.blur="email" required
                    class="w-full bg-[#1e293b] border border-white/10 rounded-lg p-3 text-white focus:border-[#036482] focus:ring-1 focus:ring-[#036482] outline-none transition-all placeholder-slate-600"
                    placeholder="name@company.com" type="email" value="">
                <flux:error name="email" />
            </div>
        </div>
        <div><label class="block text-sm text-slate-400 font-medium mb-2">Subject*</label><input
                wire:model.blur="subject" required
                class="w-full bg-[#1e293b] border border-white/10 rounded-lg p-3 text-white focus:border-[#036482] focus:ring-1 focus:ring-[#036482] outline-none transition-all placeholder-slate-600"
                placeholder="How can we help?" type="text" value="">
            <flux:error name="subject" />
        </div>
        <div><label class="block text-sm text-slate-400 font-medium mb-2">Message*</label>
            <textarea rows="5" required wire:model.live="message" maxlength="500"
                class="w-full bg-[#1e293b] border border-white/10 rounded-lg p-3 text-white focus:border-[#036482] focus:ring-1 focus:ring-[#036482] outline-none transition-all placeholder-slate-600 resize-none"
                placeholder="Tell us about your dealership compliance needs..."></textarea>
            <div class="text-sm text-slate-500 mt-1 text-right">
                <span x-text="$wire.message.length"></span>/500
            </div>
            <flux:error name="message" />
        </div>
        <x-turnstile wire:model="cfTurnstileResponse" />
        <flux:error name="cfTurnstileResponse" />
        <button type="submit"
            class="w-full bg-[#036482] hover:bg-[#EC7700] hover:cursor-pointer text-white font-bold py-4 rounded-lg transition-all shadow-lg hover:shadow-[#EC7700]/20 flex items-center justify-center gap-2"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-send w-5 h-5" aria-hidden="true">
                <path
                    d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
                </path>
                <path d="m21.854 2.147-10.94 10.939"></path>
            </svg> Send Message</button>
    </form>

    <div x-cloak x-show="$wire.submitted" class="text-center py-10 animate-in fade-in zoom-in duration-500">
        <div
            class="w-24 h-24 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-check-big w-12 h-12 text-green-500" aria-hidden="true">
                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                <path d="m9 11 3 3L22 4"></path>
            </svg>
        </div>
        <h3 class="text-3xl font-bold text-white mb-4">Message Sent!</h3>
        <p class="text-slate-400 leading-relaxed mb-10">Thank you for contacting Auto Risk Management Partners.
            <br>We have received your inquiry and will be in touch shortly.
        </p>
    </div>
</div>
