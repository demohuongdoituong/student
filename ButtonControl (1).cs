using UnityEngine;
using System.Collections;

public class ButtonControl : MonoBehaviour {
	public ButtonControl.ButtonType bt;
	// Use this for initialization
	void Start () {
	
	}
	public ButtonControl(){	
		
	}
	private void OnMouseDown(){
		transform.localScale = new Vector3 (0.48f, 0.48f);
	}
	private void OnMouseUp(){
		transform.localScale = new Vector3 (0.5f, 0.5f);
		if (bt == ButtonControl.ButtonType.btnPlay) {
			Application.LoadLevel ("playing2");
		}
	}
	// Update is called once per frame
	void Update () {
	
	}
	public enum ButtonType{
		btnPlay
	}
}
