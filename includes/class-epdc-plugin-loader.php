<?php
/**
 * Loader for registering plugin hooks.
 *
 * @package EPDC_Product_Selector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPDC_Plugin_Loader {

	/**
	 * Action hooks.
	 *
	 * @var array<int, array<string, mixed>>
	 */
	private array $actions = [];

	/**
	 * Filter hooks.
	 *
	 * @var array<int, array<string, mixed>>
	 */
	private array $filters = [];

	/**
	 * Queue an action hook.
	 *
	 * @param string   $hook_name      Hook name.
	 * @param object   $component      Component instance.
	 * @param string   $callback       Callback method.
	 * @param int      $priority       Priority.
	 * @param int      $accepted_args  Accepted args.
	 */
	public function add_action( string $hook_name, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ): void {
		$this->actions[] = [
			'hook'          => $hook_name,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		];
	}

	/**
	 * Queue a filter hook.
	 *
	 * @param string   $hook_name      Hook name.
	 * @param object   $component      Component instance.
	 * @param string   $callback       Callback method.
	 * @param int      $priority       Priority.
	 * @param int      $accepted_args  Accepted args.
	 */
	public function add_filter( string $hook_name, object $component, string $callback, int $priority = 10, int $accepted_args = 1 ): void {
		$this->filters[] = [
			'hook'          => $hook_name,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		];
	}

	/**
	 * Register queued hooks with WordPress.
	 */
	public function run(): void {
		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], [ $hook['component'], $hook['callback'] ], $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], [ $hook['component'], $hook['callback'] ], $hook['priority'], $hook['accepted_args'] );
		}
	}
}
